<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    /**
     * اعمال کوپن به سفارش
     */
    public function applyToOrder(Order $order, string $code): void
    {
        $coupon = $this->validateCoupon($code);
        $user = $order->user;

        // بررسی استفاده قبلی
        if ($coupon->users()->where('users.id', $user->id)->exists()) {
            throw new \Exception("شما قبلاً از این کد تخفیف استفاده کرده‌اید.");
        }

        $discount = $this->calculateDiscount($coupon, $order->total_price);

        $order->discount_amount = $discount;
        $order->final_price = max($order->total_price - $discount, 0);
        $order->save();

        $user->coupons()->attach($coupon->id, [
            'order_id' => $order->id,
            'used_at' => now(),
        ]);
    }

    /**
     * اعتبارسنجی کوپن
     */
    public function validateCoupon(string $code): Coupon
    {
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$coupon) {
            throw new \Exception("کد تخفیف معتبر نیست یا منقضی شده است.");
        }

        return $coupon;
    }

    /**
     * محاسبه میزان تخفیف
     */
    public function calculateDiscount(Coupon $coupon, int $totalPrice): int
    {
        if ($coupon->discount_amount) {
            return min($coupon->discount_amount, $totalPrice);
        }

        if ($coupon->discount_percent) {
            return floor($totalPrice * $coupon->discount_percent / 100);
        }

        return 0;
    }
}
