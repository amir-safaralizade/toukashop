<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'guest_token',
        'status',
        'total_price',
        'discount_amount',
        'final_price',
        'tracking_code',
        'fullname',
        'phone',
        'notes',
        'payment_method'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'payable');
    }


    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public const STATUSES = [
        'pending' => 'در انتظار پرداخت',
        'paid' => 'پرداخت‌شده',
        'shipped' => 'ارسال‌شده',
        'completed' => 'تکمیل‌شده',
        'canceled' => 'لغوشده',
    ];

    public function getStatusFaAttribute()
    {
        return self::STATUSES[$this->status] ?? 'نامشخص';
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user')
            ->withPivot('used_at')
            ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'order_item_attribute_values')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
}
