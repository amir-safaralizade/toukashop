<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProductSection extends Model
{
    protected $fillable = ['title', 'source_type', 'category_id', 'tag_id', 'product_ids', 'products_limit', 'sort_order', 'is_active'];

    protected $casts = [
        'product_ids' => 'array',
        'products_limit' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function productsForDisplay()
    {
        $relations = ['category', 'mediaFiles', 'variants.attributeValues.attribute'];
        $query = Product::with($relations);

        if ($this->source_type === 'category') {
            $query->where('category_id', $this->category_id)->latest();
        } elseif ($this->source_type === 'tag') {
            $query->whereHas('tags', fn ($tags) => $tags->where('tags.id', $this->tag_id))->latest();
        } elseif ($this->source_type === 'custom') {
            $ids = collect($this->product_ids)->map(fn ($id) => (int) $id)->filter()->values();
            if ($ids->isEmpty()) return collect();
            $query->whereIn('id', $ids)->orderByRaw('FIELD(id, ' . $ids->implode(',') . ')');
        } else {
            $query->latest();
        }

        return $query->take(max(1, min(20, $this->products_limit)))->get();
    }
}
