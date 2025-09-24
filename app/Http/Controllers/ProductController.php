<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('name', 'products')->firstOrFail();
        recordVisit($page);

        $sort = $request->query('sort', 'newest'); // default sort

        $query = Product::query();

        // فیلتر بر اساس دسته‌بندی
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // فیلتر بر اساس جستجو
        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // اضافه کردن تعداد فروش واقعی از order_items
        $query->withCount(['orderItems as total_sold' => function ($q) {
            $q->select(DB::raw("COALESCE(SUM(quantity),0)"));
        }]);

        // اعمال مرتب‌سازی
        switch ($sort) {
            case 'bestselling':
                $query->orderBy('total_sold', 'desc');
                break;

            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // مرتب‌سازی ثانویه: موجودی و ID
        $query->orderBy('stock', 'desc')->orderBy('id', 'desc');

        $products = $query->get();
        $categories = Category::all();

        return view('site.pages.products.index', compact('products', 'categories', 'sort'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrfail();
        recordVisit($product);

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

    public function category(Request $request, $slug)
    {

        $category = Category::where('type', 'product')->where('slug', $slug)->firstOrFail();
        recordVisit($category);

        $sort = request()->query('sort', 'newest');

        $productsQuery = Product::where('category_id', $category->id);

        // اضافه کردن تعداد فروش واقعی از جدول order_items
        $productsQuery->withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw("COALESCE(SUM(quantity),0)"));
        }]);

        // اعمال مرتب‌سازی
        switch ($sort) {
            case 'bestselling':
                $productsQuery->orderBy('total_sold', 'desc');
                break; 

            case 'price_low_high':
                $productsQuery->orderBy('price', 'asc');
                break;

            case 'price_high_low':
                $productsQuery->orderBy('price', 'desc');
                break;

            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        // مرتب‌سازی ثانویه: موجودی و ID
        $productsQuery->orderBy('stock', 'desc')->orderBy('id', 'desc');

        $products = $productsQuery->get();

        $categories = Category::where('type', 'product')->get();

        return view('site.pages.products.category', compact('products', 'categories', 'category', 'slug', 'sort'));
    }
}
