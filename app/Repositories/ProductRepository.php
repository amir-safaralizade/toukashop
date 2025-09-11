<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with('category')->get();
    }

    public function find(int $id): ?Product
    {
        return $this->model->with('category')->find($id);
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->find($id);
        return $product ? $product->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);
        return $product ? $product->delete() : false;
    }

    public function search(string $query, ?int $categoryId = null): Collection
    {
        return $this->model
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->with('category')
            ->get();
    }
}
