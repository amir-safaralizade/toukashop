<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Tag;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\HomeProductSection;
use Exception;

class HomeController extends Controller
{
    public function home()
    {
        $page = Page::where('name', 'home')->firstOrfail();
        recordVisit($page);

        $productRelations = ['category', 'mediaFiles', 'variants.attributeValues.attribute'];
        $configuredIds = collect(explode('+', (string) site_setting('best-selling-products-home-page')))
            ->map(fn ($id) => (int) $id)->filter()->unique()->values();

        $products = Product::with($productRelations)
            ->when($configuredIds->isNotEmpty(), function ($query) use ($configuredIds) {
                $query->whereIn('id', $configuredIds)
                    ->orderByRaw('FIELD(id, ' . $configuredIds->implode(',') . ')');
            }, function ($query) {
                $query->withSum('orderItems as sold_quantity', 'quantity')->orderByDesc('sold_quantity');
            })
            ->take(8)->get();

        $data = new stdClass();
        $data->products = $products;
        $data->new_products = Product::with($productRelations)->latest()->take(8)->get();
        $data->variety_products = Product::with($productRelations)
            ->whereHas('variants.attributeValues')->where('stock', '>', 0)->latest()->take(6)->get();
        $data->posts = Post::with('category')->latest()->take(3)->get();
        $data->sliders = Slider::orderBy('sort_order')->get();
        $data->banners = Banner::orderBy('id')->take(3)->get();
        $data->page = $page;
        $data->animal_tags = Tag::withCount('products')->whereHas('products')->orderByDesc('products_count')->take(6)->get();
        $data->product_sections = Schema::hasTable('home_product_sections')
            ? HomeProductSection::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()
                ->map(function ($section) {
                    $section->display_products = $section->productsForDisplay();
                    return $section;
                })->filter(fn ($section) => $section->display_products->isNotEmpty())->values()
            : collect();

        return view('site.pages.home', compact('data'));
    }


    public function privacy()
    {
        $page = Page::where('name', 'privacy')->firstOrfail();
        recordVisit($page);
        return view('site.pages.privacy');
    }

    public function orderTracking()
    {
        $page = Page::where('name', 'order-tracking')->firstOrfail();
        recordVisit($page);
        return view('site.pages.orderTracking');
    }

    public function sizeSelectionGuide()
    {
        $page = Page::where('name', 'size-selection-guide')->firstOrfail();
        recordVisit($page);
        return view('site.pages.sizeSelectionGuide', compact('page'));
    }

    public function aboutUs()
    {
        $page = Page::where('name', 'about_us')->firstOrfail();
        recordVisit($page);
        return view('site.pages.about_us', compact('page'));
    }

    public function search_page(Request $request)
    {
        $sort = $request->query('sort', 'newest'); // default sort

        $query = Product::query();

        // فیلتر بر اساس دسته‌بندی
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // فیلتر بر اساس جستجو
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tags', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
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
        return view('site.pages.search_page', compact('products', 'categories', 'sort'));
    }
}
