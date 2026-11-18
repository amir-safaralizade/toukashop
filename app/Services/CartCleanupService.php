<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CartCleanupService
{
    public function clean(Order $cart): int
    {
        return DB::transaction(function () use ($cart) {
            $lockedCart = Order::whereKey($cart->id)->lockForUpdate()->firstOrFail();
            if ($lockedCart->status !== 'pending') return 0;

            $unavailable = $lockedCart->items()
                ->whereDoesntHave('product', fn ($query) => $query->where('status', true))
                ->lockForUpdate()->get();
            if ($unavailable->isEmpty()) return 0;

            foreach ($unavailable as $item) {
                $item->attributeValues()->detach();
                $item->delete();
            }
            $total = (int) $lockedCart->items()->sum('total_price');
            $discount = min(max(0, (int) $lockedCart->discount_amount), $total);
            $lockedCart->update([
                'total_price' => $total,
                'discount_amount' => $discount,
                'final_price' => max(0, $total - $discount),
                'shipping_cost' => $total > 0 ? $lockedCart->shipping_cost : 0,
            ]);
            return $unavailable->count();
        }, 3);
    }
}
