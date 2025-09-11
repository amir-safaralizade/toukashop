<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected string $cacheKey = 'products';

    public function all(): Collection
    {
        return Cache::remember($this->cacheKey . '_all', now()->addHour(), function () {
            return Product::with('category')->get();
        });
    }

    public function find(int $id): ?Product
    {
        return Cache::remember($this->cacheKey . "_id_{$id}", now()->addHour(), function () use ($id) {
            return Product::with('category')->find($id);
        });
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);
        $this->forgetCache();
        return $product;
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        if ($product) {
            $result = $product->update($data);
            $this->forgetCache();
            return $result;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        if ($product) {
            $result = $product->delete();
            $this->forgetCache();
            return $result;
        }
        return false;
    }

    public function search(string $query, ?int $categoryId = null): Collection
    {
        return Cache::remember(
            $this->cacheKey . "_search_{$query}_{$categoryId}",
            now()->addHour(),
            function () use ($query, $categoryId) {
                return Product::where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
                    ->with('category')
                    ->get();
            }
        );
    }

    protected function forgetCache(): void
    {
        Cache::forget($this->cacheKey . '_all');
        // می‌تونی منطق اضافی برای پاک کردن کش‌های خاص اضافه کنی
    }
}