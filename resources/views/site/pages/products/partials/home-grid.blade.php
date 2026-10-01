@if($sliderMode ?? false)<div class="product-slider-shell"><button class="product-slider-btn prev" type="button" data-slider-prev aria-label="محصولات قبلی"><i class="bi bi-chevron-right"></i></button>@endif
<div class="{{ ($sliderMode ?? false) ? 'home-products-slider' : 'product-grid-home' }}" @if($sliderMode ?? false) data-products-track @endif>
    @forelse($homeProducts as $product)
        @php
            $image = $product->mediaFiles->firstWhere('group', 'main_image');
            $variantValues = $product->variants->flatMap->attributeValues->unique('id');
            $colorValues = $variantValues->filter(fn ($value) => in_array(mb_strtolower($value->attribute?->name ?? ''), ['color', 'colour', 'رنگ'], true));
            $otherValues = $variantValues->reject(fn ($value) => $colorValues->contains('id', $value->id))->take(2);
            $availablePrices = $product->variants->where('stock', '>', 0)->pluck('price')->filter();
            $displayPrice = $availablePrices->min() ?? $product->price;
        @endphp
        <article class="home-product">
            <a class="home-product-image" href="{{ route('products.show', $product->slug) }}">
                <img loading="lazy" src="{{ $image?->full_url ?? asset('images/default-product.jpg') }}" alt="{{ $product->name }}">
                <span class="home-chip {{ $product->stock > 0 ? '' : 'out' }}">{{ $product->stock > 0 ? $badge : 'ناموجود' }}</span>
            </a>
            <div class="home-product-body">
                @if($product->category)<a class="home-product-category" href="{{ route('products.categories', $product->category->slug) }}">{{ $product->category->name }}</a>@endif
                <h3><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                <div class="variant-preview" aria-label="تنوع محصول">
                    @foreach($colorValues->take(5) as $value)
                        @if(preg_match('/^#(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $value->value))
                            <span class="variant-dot" style="background-color:{{ $value->value }}" title="{{ $value->display_value }}"></span>
                        @else
                            <span class="variant-text">{{ $value->display_value }}</span>
                        @endif
                    @endforeach
                    @foreach($otherValues as $value)<span class="variant-text">{{ $value->display_value }}</span>@endforeach
                    @if($variantValues->isEmpty())<span class="variant-text">آماده سفارش</span>@endif
                </div>
                <div class="home-product-foot"><span class="home-price">{{ number_format($displayPrice) }} تومان</span><a class="product-arrow" href="{{ route('products.show', $product->slug) }}" aria-label="مشاهده {{ $product->name }}"><i class="bi bi-arrow-left"></i></a></div>
            </div>
        </article>
    @empty
        <div class="catalog-empty" style="grid-column:1/-1">هنوز محصولی برای نمایش وجود ندارد.</div>
    @endforelse
</div>
@if($sliderMode ?? false)<button class="product-slider-btn next" type="button" data-slider-next aria-label="محصولات بعدی"><i class="bi bi-chevron-left"></i></button></div>@endif
