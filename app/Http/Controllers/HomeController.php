<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use stdClass;


class HomeController extends Controller
{
    public function home()
    {
        $page = Page::where('name' , 'home')->firstOrfail();
        recordVisit($page);
        $products = Product::orderBy('id', 'desc')->take(4)->get();
        $special_products = Product::orderBy('id', 'desc')->where('category_id', 2)->take(6)->get();
        $data = new stdClass();
        $data->products = $products;
        $data->special_products = $special_products;
        return view('site.pages.home', compact('data'));
    }


    public function privacy()
    {
        $page = Page::where('name' , 'privacy')->firstOrfail();
        recordVisit($page);
        return view('site.pages.privacy');
    }

    public function orderTracking()
    {
        $page = Page::where('name' , 'order-tracking')->firstOrfail();
        recordVisit($page);
        return view('site.pages.orderTracking');
    }

    public function sizeSelectionGuide()
    {
        $page = Page::where('name' , 'size-selection-guide')->firstOrfail();
        recordVisit($page);
        return view('site.pages.sizeSelectionGuide');
    }
}
