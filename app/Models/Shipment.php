<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'status',
        'shipping_provider',
        'tracking_number',
        'postal_code',
        'shipping_province_id',
        'shipping_city_id',
        'shipping_address',
        'shipping_cost',
        'shipped_at',
        'delivered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'postal_code' => 'integer',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order that owns the shipment.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the province associated with the shipment.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'shipping_province_id');
    }

    /**
     * Get the city associated with the shipment.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'shipping_city_id');
    }
}
