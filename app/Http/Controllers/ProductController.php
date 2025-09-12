<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Page;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('name', 'products')->firstOrfail();
        recordVisit($page);
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('query')) {
            $search = $request->input('query');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->get();
        $categories = Category::all();
        return view('site.pages.products.index', compact('products', 'categories'));
    }


    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrfail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $product->load('attributeValues.attribute');
        recordVisit($product);
        return view('site.pages.products.show', compact('product', 'relatedProducts'));
    }

    public function tests()
    {
        foreach (Product::all() as $product) {
            $product->slug = persian_slug($product->name);
            $product->save();
        }
    }

    public function category($slug)
    {
        $category = Category::where('type', 'product')->where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->orderBy('stock', 'desc')->orderBy('id', 'desc')->get();
        $categories = Category::where('type', 'product')->get();
        return view('site.pages.products.category', compact('products', 'categories', 'category' , 'slug'));
    }
}
