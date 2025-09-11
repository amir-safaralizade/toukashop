<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Services\CouponService;

class OrderService
{
    public function createOrder(array $cartItems, ?string $shippingAddress = null): Order
    {
        return DB::transaction(function () use ($cartItems, $shippingAddress) {
            $totalPrice = 0;

            $order = new Order();
            $order->user_id = Auth::id();
            $order->status = 'pending';
            $order->discount_amount = 0;
            $order->tracking_code = $this->gen_tracking_code();

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $unitPrice = $product->price;
                $total = $unitPrice * $quantity;
                $totalPrice += $total;
            }

            $order->total_price = $totalPrice;
            $order->final_price = $totalPrice;
            $order->save();

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $unitPrice = $product->price;
                $total = $unitPrice * $quantity;

                $orderItem = $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $total,
                ]);

                if (!empty($item['attributes']) && is_array($item['attributes'])) {
                    foreach ($item['attributes'] as $attributeId => $attributeValueId) {
                        $orderItem->attributeValues()->attach($attributeValueId, [
                            'attribute_id' => $attributeId,
                        ]);
                    }
                }
            }

            return $order;
        });
    }

    public function applyCoupon(Order $order, string $code, CouponService $couponService): void
    {
        $couponService->applyToOrder($order, $code);
    }

    public function finalizeOrder(Order $order): void
    {
        if ($order->status !== 'pending') {
            throw new \Exception("فقط سفارش‌هایی که در وضعیت در انتظار هستند قابل نهایی‌سازی‌اند.");
        }

        if ($order->items()->count() === 0) {
            throw new \Exception("نمی‌توان سفارشی بدون آیتم را نهایی کرد.");
        }

        if ($order->final_price <= 0) {
            throw new \Exception("مبلغ سفارش نامعتبر است.");
        }

        if (!$order->shipment) {
            throw new \Exception("اطلاعات ارسال برای این سفارش ثبت نشده است.");
        }

        $order->status = 'ready_to_pay';
        $order->save();
    }

    public function markAsPaid(Order $order): void
    {
        DB::transaction(function () use ($order) {
            if ($order->status === 'paid') {
                throw new \Exception("این سفارش قبلاً پرداخت شده است.");
            }

            $order->status = 'paid';
            $order->save();

            foreach ($order->items as $item) {
                $product = $item->product;

                // If stock is enough
                if ($product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                } else {
                    // If stock is less than needed → set it to zero
                    $product->update(['stock' => 0]);
                }
            }
        });
    }



    public function markAsFailed(Order $order, string $errorMessage = null): void
    {
        if ($order->status === 'paid') {
            throw new \Exception("نمی‌توان وضعیت پرداخت را تغییر داد، سفارش قبلاً پرداخت شده است.");
        }

        $order->transactions()->create([
            'gateway' => 'zarinpal',
            'ref_id' => null,
            'amount' => $order->final_price,
            'status' => 'failed',
            'paid_at' => null,
        ]);

        $order->status = 'failed';
        $order->save();

        if ($errorMessage) {
            logger()->warning("پرداخت ناموفق برای سفارش #{$order->id}: " . $errorMessage);
        }
    }

    public function cancelOrder(Order $order): void
    {
        if (!in_array($order->status, ['pending', 'ready_to_pay', 'failed'])) {
            throw new \Exception("سفارش در وضعیت فعلی قابل لغو نیست.");
        }

        $order->status = 'canceled';
        $order->save();

        logger()->info("سفارش #{$order->id} لغو شد.");
    }

    public function deleteOrder(Order $order): bool
    {
        if (!in_array($order->status, ['pending', 'failed', 'canceled'])) {
            throw new \Exception("سفارش‌هایی که در حال پردازش یا تکمیل‌شده‌اند قابل حذف نیستند.");
        }

        $order->items()->delete();
        $order->transactions()->delete();
        $order->shipment()?->delete();

        return $order->delete();
    }

    public function getUserOrders(int $userId): Collection
    {
        return Order::with('items', 'transactions', 'shipment')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    private function gen_tracking_code(): string
    {
        do {
            $part1 = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            $part2 = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            $code = date('y') . $part1 . $part2;
        } while (Order::where('tracking_code', $code)->exists());

        return $code;
    }

    public function getCurrentCart(bool $createIfNotExists = false, bool $justSize = false)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with('items.product')
            ->first();

        if ($justSize) {
            return $order ? $order->items->count() : 0;
        }


        if (!$order && $createIfNotExists) {
            $order = $this->createOrder([]);
        }

        if (!$order) {
            abort(404, 'سبد خرید پیدا نشد.');
        }

        return $order;
    }
}
