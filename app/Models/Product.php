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
            $builder->where('status', true);
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            \App\Models\Tag::class,
            'tag_objects',
            'object_id',
            'tag_id'
        );
    }

    /** ✅ Add this missing relationship */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function availableVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('stock', '>', 0);
    }

    public function updateTotalStock()
    {
        $total_stock = $this->variants()->sum('stock');
        $this->stock = $total_stock;
        $this->save();
    }

    public function hasVariants(): bool
    {
        return $this->variants()->count() > 0;
    }

    public function getMinVariantPrice()
    {
        if (!$this->hasVariants()) {
            return $this->price;
        }

        return $this->availableVariants()->min('price') ?? $this->price;
    }

    // متد کمکی برای گرفتن حداکثر قیمت واریانت‌ها
    public function getMaxVariantPrice()
    {
        if (!$this->hasVariants()) {
            return $this->price;
        }

        return $this->availableVariants()->max('price') ?? $this->price;
    }


    public function getMinVariantPriceAttribute()
    {
        if (!$this->hasAvailableVariants()) {
            return $this->price;
        }

        return $this->availableVariants()->min('price') ?? $this->price;
    }

    /**
     * گرفتن حداکثر قیمت واریانت‌ها
     */
    public function getMaxVariantPriceAttribute()
    {
        if (!$this->hasAvailableVariants()) {
            return $this->price;
        }

        return $this->availableVariants()->max('price') ?? $this->price;
    }

    public function hasAvailableVariants(): bool
    {
        return $this->variants()->where('stock', '>', 0)->count() > 0;
    }


    public function technicalDetails()
    {
        return $this->hasMany(TechnicalDetail::class);
    }
}
