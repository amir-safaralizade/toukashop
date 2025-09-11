<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SiteMapCpntroller extends Controller
{
    public function generate(Request $request)
    {
        \Log::info('salammmmmm');
        $pass_key = 'dzbryryvub';

        if ($request->has('pass_key23') && $request['pass_key23'] == $pass_key) {
            $sitemap = Sitemap::create();

            // صفحات ثابت
            $sitemap
                ->add(
                    Url::create(route('page.home'))
                        ->setPriority(1.0)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                        ->setLastModificationDate(Carbon::now())
                )
                ->add(
                    Url::create(route('page.privacy'))
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                )
                ->add(
                    Url::create(route('page.orderTracking'))
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                )
                ->add(
                    Url::create(route('page.size-selection-guide'))
                        ->setPriority(0.6)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                )
                ->add(
                    Url::create(route('products.index'))
                        ->setPriority(0.7)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                );

            // دسته‌های محصولات
            Category::query()
                ->select(['id', 'slug', 'updated_at'])
                ->where('type', 'product')
                ->orderBy('id')
                ->chunk(1000, function ($cats) use ($sitemap) {
                    foreach ($cats as $cat) {
                        $sitemap->add(
                            Url::create(route('products.categories', ['slug' => $cat->slug]))
                                ->setPriority(0.6)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setLastModificationDate($cat->updated_at instanceof \DateTimeInterface ? $cat->updated_at : now())
                        );
                    }
                });
                
            // محصولات
            Product::query()
                ->select(['id', 'slug', 'updated_at'])
                ->orderByDesc('id')
                ->chunk(1000, function ($products) use ($sitemap) {
                    foreach ($products as $p) {
                        $sitemap->add(
                            Url::create(route('products.show', ['slug' => $p->slug]))
                                ->setPriority(0.8)
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                ->setLastModificationDate($p->updated_at instanceof \DateTimeInterface ? $p->updated_at : now())
                        );
                    }
                });


            $sitemap->writeToFile('sitemap.xml');

            return 'sitemap.xml generated';
        } else {
            return 'done';
        }
    }
}
