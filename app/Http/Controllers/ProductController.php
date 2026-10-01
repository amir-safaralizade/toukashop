<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('name', 'products')->firstOrFail();
        recordVisit($page);

        $catalog = $this->buildCatalog($request);

        return view('site.pages.products.index', $catalog + [
            'catalogTitle' => 'همه محصولات',
            'currentCategory' => null,
        ]);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        recordVisit($product);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // بارگذاری واریانت‌ها و موجودی‌ها - استفاده از variants
        $product->load([
            'attributeValues.attribute',
            'variants.attributeValues.attribute'
        ]);

        // ساختار داده‌ای برای مدیریت موجودی در فرانت‌اند
        $variantStockData = [];

        // اگر واریانتی وجود دارد
        if ($product->variants->count() > 0) {
            foreach ($product->variants as $variant) {
                // فقط واریانت‌های موجود را اضافه کن
                if ($variant->stock > 0) {
                    $attributes = [];
                    foreach ($variant->attributeValues as $attrValue) {
                        $attributes['attribute_' . $attrValue->attribute_id] = $attrValue->id;
                    }

                    $variantStockData[] = [
                        'variant_id' => $variant->id,
                        'stock' => $variant->stock,
                        'attributes' => $attributes,
                        'price' => $variant->price ?? $product->price
                    ];
                }
            }

            // اگر هیچ واریانت موجودی پیدا نشد
            if (count($variantStockData) === 0) {
                $variantStockData[] = [
                    'variant_id' => 0,
                    'stock' => 0,
                    'attributes' => [],
                    'price' => $product->price
                ];
            }
        } else {
            // اگر محصول واریانت ندارد، خود محصول را به عنوان یک واریانت در نظر بگیرید
            $variantStockData[] = [
                'variant_id' => 0,
                'stock' => $product->stock,
                'attributes' => [],
                'price' => $product->price
            ];
        }

        recordVisit($product);
        return view('site.pages.products.show', compact(
            'product',
            'relatedProducts',
            'variantStockData'
        ));
    }


    public function tests()
    {

        // پیدا کردن محصولاتی که صفت دارند اما واریانت ندارند
        $products = Product::whereDoesntHave('variants')
            ->whereHas('attributes')
            ->get();

        if ($products->isEmpty()) {
            return;
        }
        foreach ($products as $product) {
            // ایجاد واریانت جدید با موجودی ۰
            $variant = new ProductVariant([
                'product_id' => $product->id,
                'stock' => 0,

                'sku' => $product->slug . '-default', // می‌تونی SKU رو به دلخواه تغییر بدی یا تولید کنی
            ]);
            $variant->save();

            // کپی صفت‌ها و مقادیرشون از محصول به واریانت
            foreach ($product->attributes as $attribute) {
                $value_id = $attribute->pivot->attribute_value_id;
                $variant->attributes()->attach($attribute->id, ['attribute_value_id' => $value_id]);
            }

            // آپدیت مجموع موجودی محصول (بر اساس متد موجود در مدل)
            $product->updateTotalStock();
        }


        return;
    }

    public function category(Request $request, $slug)
    {

        $category = Category::where('type', 'product')->where('slug', $slug)->firstOrFail();
        recordVisit($category);

        $catalog = $this->buildCatalog($request, $category);

        return view('site.pages.products.category', $catalog + [
            'category' => $category,
            'slug' => $slug,
            'catalogTitle' => $category->name,
            'currentCategory' => $category,
        ]);
    }

    public function tag(Request $request, $slug)
    {

        $tag = Tag::where('slug', $slug)->firstOrFail();
        recordVisit($tag);

        $sort = $request->query('sort', 'newest'); // default sort

        // شروع query روی محصولات
        $query = Product::query()
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            });

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

        return view('site.pages.tag', compact('products', 'sort', 'tag'));
    }

    private function buildCatalog(Request $request, ?Category $fixedCategory = null): array
    {
        $validated = $request->validate([
            'query' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
            'in_stock' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:newest,bestselling,price_low_high,price_high_low,name_az'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['nullable', 'array'],
            'attributes.*.*' => ['integer', 'exists:attribute_values,id'],
        ]);

        $sort = $validated['sort'] ?? 'newest';
        $query = Product::query()
            ->with(['category', 'mediaFiles'])
            ->withCount(['orderItems as total_sold' => fn ($orders) =>
                $orders->select(DB::raw('COALESCE(SUM(quantity),0)'))
            ]);

        if ($fixedCategory) {
            $query->where('category_id', $fixedCategory->id);
        } elseif (!empty($validated['category'])) {
            $query->where('category_id', $validated['category']);
        }

        if (!empty($validated['query'])) {
            $term = trim($validated['query']);
            $query->where(function (Builder $products) use ($term) {
                $products->where('name', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%')
                    ->orWhereHas('category', fn ($category) => $category->where('name', 'like', '%' . $term . '%'));
            });
        }

        if (isset($validated['min_price'])) {
            $query->where('price', '>=', $validated['min_price']);
        }
        if (isset($validated['max_price'])) {
            $query->where('price', '<=', $validated['max_price']);
        }
        if (!empty($validated['in_stock'])) {
            $query->where('stock', '>', 0);
        }

        foreach (array_filter($validated['attributes'] ?? []) as $attributeId => $valueIds) {
            if (!$valueIds) continue;
            $query->whereHas('attributeValues', function (Builder $values) use ($attributeId, $valueIds) {
                $values->where('attribute_values.attribute_id', (int) $attributeId)
                    ->whereIn('attribute_values.id', array_map('intval', $valueIds));
            });
        }

        match ($sort) {
            'bestselling' => $query->orderByDesc('total_sold'),
            'price_low_high' => $query->orderBy('price'),
            'price_high_low' => $query->orderByDesc('price'),
            'name_az' => $query->orderBy('name'),
            default => $query->latest('created_at'),
        };
        $query->orderByDesc('stock')->orderByDesc('id');

        return [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::where('type', 'product')->withCount('products')->orderBy('name')->get(),
            'filterAttributes' => Attribute::with(['values' => fn ($values) => $values->orderBy('value')])->orderBy('name')->get(),
            'sort' => $sort,
        ];
    }
}
