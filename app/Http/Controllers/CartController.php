<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\Transaction;
use App\Services\OrderService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Page;
use App\Models\ProductVariant;
use App\Models\Shipment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        $is_online_pay_active = true;
        $order = $this->orderService->getCurrentCart(true);
        $order->load([
            'items.product',
            'items.attributeValues.attribute'
        ]);

        $post_cost = intval(site_setting('shipping-cost'));
       
        if ($order) {
            foreach ($order->items as $item) {
                $post_cost += $item->product->transportation_unit * 10000;
            }
        }

        $provinces = Province::all();
        return view('site.pages.cart', compact('order', 'provinces', 'is_online_pay_active' , 'post_cost'));
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
                'attributes.*' => 'nullable|integer|exists:attribute_values,id',
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
                foreach ($request->input('attributes', []) as $attributeValueId) {
                    if (!empty($attributeValueId)) {
                        $attrValue = AttributeValue::find($attributeValueId);
                        if ($attrValue) $attributes[$attrValue->attribute_id] = $attributeValueId;
                    }
                }
            }

            // ========== FIND VARIANT ==========
            $variant = null;

            if (!empty($attributes)) {
                $variantQuery = ProductVariant::where('product_id', $product->id)
                    ->where('is_active', true)
                    ->has('attributeValues', '=', count($attributes));

                foreach ($attributes as $attrId => $attrValueId) {
                    $variantQuery->whereHas('attributeValues', function ($query) use ($attrId, $attrValueId) {
                        $query->where('attribute_values.id', $attrValueId)
                            ->where('product_variant_attributes.attribute_id', $attrId);
                    });
                }

                $variant = $variantQuery->first();

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
                    ->where('is_active', true)
                    ->whereDoesntHave('attributeValues')
                    ->first();

                if (!$variant && !$product->attributeValues()->exists() && !$product->variants()->exists()) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'stock' => $product->stock,
                        'price' => $product->price,
                    ]);
                }

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
                foreach ($variant->attributeValues as $attrValue) {
                    $item->attributeValues()->attach($attrValue->id, [
                        'attribute_id' => $attrValue->pivot->attribute_id,
                    ]);
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

    private function convertPersianToEnglishNumbers(?string $input): string
    {
        $localizedNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($localizedNumbers, $englishNumbers, (string) $input);
    }

    public function finalize(Request $request)
    {
        if (!auth()->check() || auth()->user()->is_guest) {
            return redirect()->route('auth.login-view', ['redirect' => 'cart'])
                ->withErrors(['auth' => 'برای نهایی کردن سفارش ابتدا شماره همراه خود را تأیید کنید.']);
        }

        $postalCode = $this->convertPersianToEnglishNumbers($request->postal_code);
        $request->merge(['postal_code' => $postalCode]);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'postal_code' => ['required', 'regex:/^[1-9][0-9]{3}[1-9][1-9][0-9]{4}$/'],
            'shipping_province_id' => ['required', 'exists:provinces,id'],
            'shipping_city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(
                    fn ($query) => $query->where('province_id', $request->shipping_province_id)
                ),
            ],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'in:Vanguard_Post'],
            'payment_method' => ['required', 'in:online,card,cod'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'postal_code.regex' => 'لطفا جهت ارسال صحیح و مطمئن مرسوله خود کد پستی صحبح وارد کنید.',
        ]);

        $order = DB::transaction(function () use ($request, $postalCode) {
            $order = Order::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->latest()
                ->lockForUpdate()
                ->firstOrFail();

            $order->load('items.product');
            if ($order->items->isEmpty()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cart' => 'سبد خرید شما خالی است!',
                ]);
            }

            $shippingCost = intval(site_setting('shipping-cost'));
            foreach ($order->items as $item) {
                $shippingCost += $item->product->transportation_unit * 10000;
            }

            Shipment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'status' => 'processing',
                    'shipping_provider' => 'پست پیشتاز',
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
                'payment_method' => $request->payment_method,
                'final_price' => $order->total_price - $order->discount_amount + $shippingCost,
            ]);

            $this->orderService->finalizeOrder($order->fresh('shipment', 'items.variant'));

            return $order->fresh();
        });

        if ($request->payment_method === 'online') {
            return redirect()->route('payment.redirect', ['order_id' => $order->id, 'provider' => config('payment.active_provider')]);
        }

        if ($request->payment_method === 'card') {
            return redirect()->route('payment.redirect', ['order_id' => $order->id, 'provider' => 'card_to_card']);
        }

        return view('checkout.success', compact('order'));
    }

    public function couponApply(Request $request, CouponService $couponService)
    {
        $validated = $request->validate(['code' => ['required', 'string', 'max:100']]);
        $order = $this->orderService->getCurrentCart();

        try {
            $couponService->applyToOrder($order, $validated['code']);
            $shippingCost = intval(site_setting('shipping-cost'));
            foreach ($order->items()->with('product')->get() as $item) {
                $shippingCost += $item->product->transportation_unit * 10000;
            }

            return response()->json([
                'success' => true,
                'message' => 'کد تخفیف اعمال شد.',
                'discount_amount' => $order->discount_amount,
                'final_amount' => $order->final_price + $shippingCost,
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function updateQuantity(Request $request, OrderItem $item)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = $item->order;

        if (!$order || $order->status !== 'pending') {
            abort(403, 'سبد قابل ویرایش نیست.');
        }

        if (!auth()->check() || $order->user_id !== auth()->id()) {
            abort(403, 'دسترسی غیرمجاز.');
        }

        $variant = $item->variant;
        if (!$variant || $variant->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'موجودی کافی نیست.',
                'available_stock' => $variant?->stock ?? 0,
            ], 422);
        }

        $item->quantity = $validated['quantity'];
        $item->total_price = $item->quantity * $item->unit_price;
        $item->save();

        $this->recalculateOrderTotals($order);

        return response()->json([
            'success' => true,
            'quantity' => $item->quantity,
            'item_total' => $item->total_price,
            'total_price' => $order->total_price,
            'final_price' => $order->final_price,
        ]);
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

        if (!$order || $order->status !== 'pending') {
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
