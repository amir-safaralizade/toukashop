<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function generate(Request $request)
    {
        $key = (string) config('sitemap.generation_key');
        abort_unless(strlen($key) >= 32 && hash_equals($key, (string) $request->query('key')), 404);

        $path = config('sitemap.path');
        $directory = dirname($path);
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new \RuntimeException('Cannot create sitemap directory.');
        }
        $lock = fopen($path . '.lock', 'c');
        if (!$lock) throw new \RuntimeException('Cannot open sitemap lock.');
        if (!flock($lock, LOCK_EX | LOCK_NB)) {
            fclose($lock);
            return response()->json(['message' => 'ساخت سایت‌مپ در حال انجام است.'], 409);
        }
        $temporary = null;
        try {
            $sitemap = Sitemap::create();
            foreach (['page.home', 'page.about_us', 'page.privacy', 'products.index', 'posts.index'] as $route) {
                $sitemap->add(Url::create(route($route)));
            }
            Category::where('type', 'product')->whereNotNull('slug')->where('slug', '!=', '')
                ->chunkById(500, function ($categories) use ($sitemap) {
                    foreach ($categories as $category) {
                        $sitemap->add(Url::create(route('products.categories', ['slug' => $category->slug])));
                    }
                });
            foreach ([Product::class => 'products.show', Post::class => 'posts.show'] as $model => $route) {
                $model::query()->whereNotNull('slug')->where('slug', '!=', '')
                    ->chunkById(500, function ($items) use ($sitemap, $route) {
                        foreach ($items as $item) {
                            $url = Url::create(route($route, ['slug' => $item->slug]));
                            if ($item->updated_at) $url->setLastModificationDate($item->updated_at);
                            $sitemap->add($url);
                        }
                    });
            }
            $temporary = tempnam($directory, 'sitemap-');
            if ($temporary === false) throw new \RuntimeException('Cannot create sitemap file.');
            $sitemap->writeToFile($temporary);
            // tempnam creates a private file (0600); nginx must be able to read the published XML.
            if (!chmod($temporary, 0644)) throw new \RuntimeException('Cannot set sitemap read permissions.');
            if (!rename($temporary, $path)) throw new \RuntimeException('Cannot replace sitemap file.');
            return response()->json([
                'message' => 'سایت‌مپ با موفقیت به‌روز شد.',
                'sitemap' => route('sitemap.show'),
                'urls' => count($sitemap->getTags()),
            ])->header('Cache-Control', 'no-store')->header('X-Robots-Tag', 'noindex, nofollow');
        } finally {
            if ($temporary && is_file($temporary)) unlink($temporary);
            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    public function show()
    {
        $path = config('sitemap.path');
        abort_unless(is_file($path), 404);
        return response()->file($path, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
