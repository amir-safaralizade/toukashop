<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalDetail extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'value'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
