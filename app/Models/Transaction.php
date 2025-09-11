<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'payable_id',
        'payable_type',
        'order_id',
        'gateway',
        'ref_id',
        'amount',
        'status',
        'description',
        'raw_response',
        'paid_at',

        // فیلدهای جدید
        'our_token',
        'Authority',
        'request_ip',
        'verify_ip',
        'card_pan',
        'card_hash',
        'fee_type',
        'fee',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function payable()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
