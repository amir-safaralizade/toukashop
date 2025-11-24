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
use App\Models\Category;
use Exception;

class HomeController extends Controller
{
    public function home()
    {
        $page = Page::where('name', 'home')->firstOrfail();
        recordVisit($page);

        try {
            $products_ids = array_map('intval', explode('+', site_setting('best-selling-products-home-page')));
        } catch (Exception $e) {
            $products_ids = [];
        }

        try {
            $second_products_ids = array_map('intval', explode('+', site_setting('second-product-list-of-the-homepage	')));
        } catch (Exception $e) {
            $second_products_ids = [];
        }


        $products = Product::whereIn('id', $products_ids)
            ->orderByRaw('FIELD(id, ' . implode(',', $products_ids) . ')')
            ->get();

        $second_products = Product::whereIn('id', $products_ids)
            ->orderByRaw('FIELD(id, ' . implode(',', $products_ids) . ')')
            ->get();

        $special_products = Product::orderBy('id', 'desc')->where('category_id', 2)->take(6)->get();
        $sliders = Slider::orderBy('sort_order', 'asc')->get();
        $banners = Banner::orderBy('id', 'asc')->take(3)->get();
        $bannerKeys = ['main_banner', 'second_banner', 'third_banner'];

        $data = new stdClass();
        $data->products = $products;
        $data->special_products = $special_products;
        $data->posts = Post::orderby('id', 'desc')->take(4)->get();
        $data->second_products = $second_products;
        $data->sliders = $sliders;
        $data->page = $page;
        foreach ($banners as $index => $banner) {
            if (isset($bannerKeys[$index])) {
                $data->{$bannerKeys[$index]} = $banner;
            }
        }

        $animal_tags =  Tag::where('type', 'animal')->get();
        $data->animal_tags = $animal_tags;
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
