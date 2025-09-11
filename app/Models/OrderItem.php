<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'order_item_attribute_values')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
}
