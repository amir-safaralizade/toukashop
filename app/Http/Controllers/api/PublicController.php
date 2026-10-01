<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function searchProducts(Request $request)
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:80'],
        ]);
        $term = trim($validated['q']);

        return Product::query()
            ->with(['category', 'mediaFiles'])
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%')
                    ->orWhereHas('category', fn ($category) => $category->where('name', 'like', '%' . $term . '%'));
            })
            ->orderByDesc('stock')
            ->latest('id')
            ->limit(8)
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'category' => $product->category?->name,
                    'price' => (int) $product->price,
                    'image' => $product->mediaFiles->firstWhere('group', 'main_image')?->full_url
                        ?? asset('images/default-product.jpg'),
                    'url' => route('products.show', $product->slug),
                ];
            })
            ->values();
    }

    public function getCities(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
        ]);

        $cities = City::where('province_id', $request->province_id)
            ->select('id', 'name')
            ->get()
            ->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                ];
            });

        return response()->json($cities, 200);
    }
}
