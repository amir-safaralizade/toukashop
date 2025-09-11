<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'discount_percent',
        'expires_at',
        'is_active'
    ];

    /**
     * Users that have used this coupon.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('order_id', 'used_at')
            ->withTimestamps();
    }

    /**
     * Get all orders that used this coupon.
     */
    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            'coupon_user',
            'coupon_id', // Foreign key on coupon_user table
            'id',        // Local key on order table
            'id',        // Local key on coupon table
            'order_id'   // Foreign key on coupon_user table
        );
    }
}
