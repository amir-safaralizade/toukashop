<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMediaFiles;
use Modules\Visit\Traits\Visitable;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasMediaFiles, Visitable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'status',
        'category_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'stock' => 'integer',
    ];


    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', true); // یا 1
        });
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    { 
        return $this->belongsToMany(Attribute::class, 'attribute_product')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_product')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
}
