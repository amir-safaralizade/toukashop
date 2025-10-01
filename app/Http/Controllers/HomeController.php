<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use stdClass;


class HomeController extends Controller
{
    public function home()
    {
        $page = Page::where('name', 'home')->firstOrfail();
        recordVisit($page);
        $products = Product::orderBy('id', 'desc')->take(4)->get();
        $special_products = Product::orderBy('id', 'desc')->where('category_id', 2)->take(6)->get();
        $sliders = Slider::orderBy('sort_order', 'asc')->get();
        $banners = Banner::orderBy('id', 'asc')->take(3)->get();
        $bannerKeys = ['main_banner', 'second_banner', 'third_banner'];

        $data = new stdClass();
        $data->products = $products;
        $data->special_products = $special_products;
        $data->posts = Post::orderby('id', 'desc')->take(4)->get();
        $data->cage_products = Product::where('category_id', 4)->OrderBy('id', 'desc')->where('stock', '>', 0)->take(4)->get();
        $data->sliders = $sliders;
        $data->page = $page;
        foreach ($banners as $index => $banner) {
            if (isset($bannerKeys[$index])) {
                $data->{$bannerKeys[$index]} = $banner;
            }
        }
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

    public function search_page()
    {
        return view('site.pages.search_page');
    }
}
