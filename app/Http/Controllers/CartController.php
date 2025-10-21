<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Transaction;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Page;
use App\Models\ProductVariant;
use App\Models\Shipment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mycart(Request $request)
    {
        $page = Page::where('name', 'mycart')->firstOrfail();
        recordVisit($page);
        $user = auth()->user();
        $is_online_pay_active = true;
        $order = Order::with([
            'items.product',
            'items.attributeValues.attribute'
        ])
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (empty($order)) {
            $order = $this->orderService->getCurrentCart(true);
        }

        $provinces = Province::all();
        return view('site.pages.cart', compact('order', 'provinces', 'is_online_pay_active'));
    }


public function addToCartAjax(Request $request)
{
    try {
        Log::info('=== addToCartAjax START ===', $request->all());

        // ========== VALIDATION ==========
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'color' => 'nullable|exists:attribute_values,id',
            'size' => 'nullable|exists:attribute_values,id',
            'attributes' => 'nullable|array',
        ]);

        $product = Product::findOrFail($request->product_id);
        $order = $this->orderService->getCurrentCart(true);
        $quantity = $request->input('quantity', 1);

        // ========== COLLECT ATTRIBUTES ==========
        $attributes = [];

        // Color
        if ($request->filled('color')) {
            $colorAttr = AttributeValue::find($request->color);
            if ($colorAttr) $attributes[$colorAttr->attribute_id] = $request->color;
        }
        
        // Size
        if ($request->filled('size')) {
            $sizeAttr = AttributeValue::find($request->size);
            if ($sizeAttr) $attributes[$sizeAttr->attribute_id] = $request->size;
        }

        // Other attributes
        if ($request->filled('attributes')) {
            foreach ($request->attributes as $attributeValueId) {
                if (!empty($attributeValueId)) {
                    $attrValue = AttributeValue::find($attributeValueId);
                    if ($attrValue) $attributes[$attrValue->attribute_id] = $attributeValueId;
                }
            }
        }

        // ========== FIND VARIANT ==========
        $variant = null;
        
        if (!empty($attributes)) {
            // Find variant with exact attributes match
            $variantQuery = DB::table('product_variant_attributes')
                ->select('product_variant_id')
                ->whereIn('product_variant_id', function($q) use ($product) {
                    $q->select('id')->from('product_variants')->where('product_id', $product->id);
                });

            foreach ($attributes as $attrId => $attrValueId) {
                $variantQuery->where('attribute_id', $attrId)->where('attribute_value_id', $attrValueId);
            }

            $variantQuery->groupBy('product_variant_id')
                ->havingRaw('COUNT(*) = ?', [count($attributes)]);

            $variantIds = $variantQuery->pluck('product_variant_id');
            $variant = ProductVariant::whereIn('id', $variantIds)->first();
            
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'ترکیب انتخاب شده موجود نمی‌باشد.',
                    'type' => 'combination_unavailable'
                ], 422);
            }
        } else {
            // Default variant (no attributes required)
            $variant = ProductVariant::where('product_id', $product->id)
                ->whereDoesntHave('attributeValues')
                ->first() ?: ProductVariant::where('product_id', $product->id)->first();
                
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'محصول موجود نمی‌باشد.',
                    'type' => 'no_default_variant'
                ], 422);
            }
        }

        // ========== STOCK VALIDATION ==========
        $totalQuantity = $quantity;
        $existingItem = $order->items()->where('product_variant_id', $variant->id)->first();
        if ($existingItem) $totalQuantity += $existingItem->quantity;

        if ($variant->stock < $totalQuantity) {
            return response()->json([
                'success' => false,
                'type' => $existingItem ? 'insufficient_stock_with_cart' : 'insufficient_stock',
                'message' => $existingItem 
                    ? "موجودی کافی نیست (در سبد: {$existingItem->quantity})"
                    : 'موجودی کافی نیست',
                'available_stock' => $variant->stock,
                'current_in_cart' => $existingItem->quantity ?? 0
            ], 422);
        }

        // ========== SAVE TO CART ==========
        if ($existingItem) {
            $existingItem->quantity = $totalQuantity;
            $existingItem->total_price = $totalQuantity * $existingItem->unit_price;
            $existingItem->save();
        } else {
            $item = $order->items()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $quantity,
                'unit_price' => $variant->price ?? $product->price,
                'total_price' => ($variant->price ?? $product->price) * $quantity,
            ]);

            // Attach attributes
            foreach ($attributes as $attrId => $attrValueId) {
                $item->attributeValues()->attach($attrValueId, ['attribute_id' => $attrId]);
            }
        }

        $this->recalculateOrderTotals($order);

        return response()->json([
            'success' => true,
            'message' => 'محصول با موفقیت به سبد خرید افزوده شد.',
            'cart_count' => $order->items()->sum('quantity'),
            'total_price' => $order->total_price,
            'final_price' => $order->final_price
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'داده‌های ارسالی نامعتبر است.',
            'type' => 'validation_error'
        ], 422);
    } catch (\Exception $e) {
        Log::error('addToCartAjax ERROR:', ['error' => $e->getMessage(), 'request' => $request->all()]);
        return response()->json([
            'success' => false,
            'message' => 'خطای سرور.',
            'type' => 'server_error'
        ], 500);
    }
}

    private function convertPersianToEnglishNumbers(string $input): string
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persianNumbers, $englishNumbers, $input);
    }

    public function finalize(Request $request)
    {
        $postalCode = $this->convertPersianToEnglishNumbers($request->postal_code);
        $request->merge(['postal_code' => $postalCode]);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'postal_code' => ['required', 'regex:/^[1-9][0-9]{3}[1-9][1-9][0-9]{4}$/'],
            'shipping_province_id' => ['required', 'exists:provinces,id'],
            'shipping_city_id' => ['required', 'exists:cities,id'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'in:Courier,Vanguard_Post'],
            'payment_method' => ['required', 'in:online,card,cod'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'postal_code.regex' => 'لطفا جهت ارسال صحیح و مطمئن مرسوله خود کد پستی صحبح وارد کنید.',
        ]);

        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->firstOrFail();

        if (sizeof($order->items) < 1) {
            return redirect()->back()->with('error', 'سبد خرید شما خالی است!');
        }

        $shippingCost = match ($request->shipping_method) {
            'Vanguard_Post' => 100000,
            'Courier' => 50000,
        };

        $shipment = Shipment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'status' => 'processing',
                'shipping_provider' => $request->shipping_method === 'post' ? 'پست پیشتاز' : ($request->shipping_method === 'tipex' ? 'تیپاکس' : 'پرداخت در محل'),
                'tracking_number' => null,
                'postal_code' => $postalCode,
                'shipping_province_id' => $request->shipping_province_id,
                'shipping_city_id' => $request->shipping_city_id,
                'shipping_address' => $request->shipping_address,
                'shipping_cost' => $shippingCost,
            ]
        );
        $order->update([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'notes' => $request->notes,
            'final_price' => $order->total_price - $order->discount_amount + $shippingCost,
        ]);

        $this->orderService->finalizeOrder($order);

        if ($request->payment_method === 'online') {
            return redirect()->route('payment.redirect', ['order_id' => $order->id, 'provider' => config('payment.active_provider')]);
        }

        if ($request->payment_method === 'card') {
            return redirect()->route('payment.redirect', ['order_id' => $order->id, 'provider' => 'card_to_card']);
        }

        return view('checkout.success', compact('order'));
    }

    public function updateQuantity(Request $request, OrderItem $item)
    {
        $order = $item->order;

        if (!$order || !in_array($order->status, ['pending', 'ready_to_pay'])) {
            abort(403, 'سبد قابل ویرایش نیست.');
        }

        if (
            ($order->user_id && auth()->check() && $order->user_id !== auth()->id()) ||
            ($order->guest_token && $order->guest_token !== session('guest_token'))
        ) {
            abort(403, 'دسترسی غیرمجاز.');
        }

        if ($request->input('action') === 'increase') {
            $item->quantity++;
        } elseif ($request->input('action') === 'decrease') {
            if ($item->quantity > 1) {
                $item->quantity--;
            } else {
                $item->delete();
                $this->recalculateOrderTotals($order);
                return redirect()->route('cart.mycart')->with('success', 'محصول حذف شد.');
            }
        }

        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $this->recalculateOrderTotals($order);

        return redirect()->route('cart.mycart')->with('success', 'تعداد بروزرسانی شد.');
    }

    private function recalculateOrderTotals(Order $order): void
    {
        $order->total_price = $order->items()->sum('total_price');
        $order->final_price = $order->total_price - $order->discount_amount;
        $order->save();
    }

    public function deleteFromCart(Request $request, OrderItem $item)
    {
        $order = $item->order;

        if (!$order || !in_array($order->status, ['pending', 'ready_to_pay'])) {
            return $request->ajax()
                ? response()->json(['error' => 'سبد قابل ویرایش نیست.'], 403)
                : abort(403, 'سبد قابل ویرایش نیست.');
        }

        // بررسی مالکیت سفارش
        if (
            ($order->user_id && auth()->check() && $order->user_id !== auth()->id()) ||
            ($order->guest_token && $order->guest_token !== session('guest_token'))
        ) {
            return $request->ajax()
                ? response()->json(['error' => 'دسترسی غیرمجاز.'], 403)
                : abort(403, 'دسترسی غیرمجاز.');
        }

        $item->delete();
        $this->recalculateOrderTotals($order);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'total_price' => $order->total_price,
                'final_price' => $order->final_price,
                'item_count' => $order->items()->count(),
            ]);
        }

        return redirect()->route('cart.mycart')->with('success', 'محصول از سبد حذف شد.');
    }

    public function clear(Request $request)
    {
        $order = $this->orderService->getCurrentCart();

        if (!in_array($order->status, ['pending'])) {
            return $request->ajax()
                ? response()->json(['error' => 'سبد قابل ویرایش نیست.'], 403)
                : abort(403, 'سبد قابل ویرایش نیست.');
        }

        $order->items()->delete();
        $order->total_price = 0;
        $order->discount_amount = 0;
        $order->final_price = 0;
        $order->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'سبد خرید خالی شد.',
            ]);
        }

        return redirect()->route('cart.mycart')->with('success', 'سبد خرید خالی شد.');
    }

    public function getItemCount()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        $itemCount = $order
            ? $order->items()->sum('quantity')
            : 0;

        return response()->json(['count' => $itemCount]);
    }

    public function FactorStatus($transaction)
    {
        try {
            $transaction =  Transaction::findOrfail(decrypt($transaction));
        } catch (Exception $e) {
            return abort(404);
        }
        return view('site.pages.factor-status', compact('transaction'));
    }
}
