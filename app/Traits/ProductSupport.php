<?php

namespace App\Traits;

use App\Services\ProductService;

trait ProductSupport
{
    protected ProductService $productService;

    public function initProductSupport(): void
    {
        $this->productService = app(ProductService::class);
    }

    public function getProduct(int $id): ?Product
    {
        return $this->productService->find($id);
    }

    public function allProducts(): Collection
    {
        return $this->productService->all();
    }

    public function searchProducts(string $query, ?int $categoryId = null): Collection
    {
        return $this->productService->search($query, $categoryId);
    }
}