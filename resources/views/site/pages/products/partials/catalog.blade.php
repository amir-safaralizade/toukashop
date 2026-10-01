@section('styles')
<style>
    body { background: #f6f7f9; color: #26323d; }
    .catalog-hero { padding: 54px 0 42px; background: linear-gradient(135deg, #fff0f3, #ecfbf9); border-bottom: 1px solid #e9eef2; }
    .catalog-breadcrumb { color: #68737f; font-size: .9rem; }
    .catalog-breadcrumb a { color: var(--primary-color); text-decoration: none; }
    .catalog-title { font-size: clamp(1.9rem, 4vw, 3rem); font-weight: 950; margin: 12px 0 8px; }
    .catalog-subtitle { color: #66717d; margin: 0; }
    .catalog-shell { padding: 34px 0 70px; }
    .category-strip { display: flex; gap: 10px; overflow-x: auto; padding: 2px 2px 18px; margin-bottom: 16px; scrollbar-width: thin; }
    .category-pill { flex: 0 0 auto; display: inline-flex; align-items: center; gap: 7px; padding: 9px 15px; border: 1px solid #dfe4e8; border-radius: 999px; background: #fff; color: #4d5965; text-decoration: none; font-size: .86rem; font-weight: 800; transition: .2s; }
    .category-pill:hover, .category-pill.active { color: #fff; border-color: var(--primary-color); background: var(--primary-color); }
    .category-pill small { opacity: .75; }
    .catalog-layout { display: grid; grid-template-columns: 285px minmax(0, 1fr); gap: 26px; align-items: start; }
    .filter-panel { background: #fff; border: 1px solid #e7eaee; border-radius: 20px; padding: 20px; position: sticky; top: 96px; box-shadow: 0 10px 30px rgba(31,41,55,.05); }
    .filter-heading { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf0f2; padding-bottom: 14px; margin-bottom: 18px; }
    .filter-heading h2 { font-size: 1.05rem; font-weight: 900; margin: 0; }
    .filter-reset { color: #d84962; font-size: .82rem; text-decoration: none; }
    .filter-group { border-bottom: 1px solid #edf0f2; padding: 0 0 18px; margin-bottom: 18px; }
    .filter-group:last-of-type { border-bottom: 0; }
    .filter-label { display: block; font-weight: 850; margin-bottom: 10px; }
    .filter-control { width: 100%; height: 44px; border: 1px solid #dfe4e8; border-radius: 12px; padding: 0 12px; background: #fff; outline: none; }
    .filter-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(233,69,96,.09); }
    .price-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .filter-check { display: flex; align-items: center; gap: 9px; margin: 8px 0; cursor: pointer; color: #505c68; }
    .filter-check input { width: 17px; height: 17px; accent-color: var(--primary-color); }
    .attribute-values { max-height: 170px; overflow-y: auto; padding-left: 4px; }
    .apply-filter { width: 100%; border: 0; border-radius: 13px; padding: 12px; background: var(--primary-color); color: #fff; font-weight: 900; }
    .catalog-toolbar { background: #fff; border: 1px solid #e7eaee; border-radius: 18px; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 20px; }
    .catalog-count { color: #66717d; font-size: .92rem; }
    .catalog-count strong { color: #26323d; }
    .sort-select { min-width: 205px; height: 42px; border: 1px solid #dfe4e8; border-radius: 12px; padding: 0 10px; background: #fff; }
    .mobile-filter-button { display: none; border: 1px solid #dfe4e8; background: #fff; border-radius: 12px; padding: 9px 12px; font-weight: 800; }
    .product-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
    .catalog-card { background: #fff; border: 1px solid #e7eaee; border-radius: 20px; overflow: hidden; transition: transform .25s, box-shadow .25s, border-color .25s; display: flex; flex-direction: column; min-width: 0; }
    .catalog-card:hover { transform: translateY(-5px); box-shadow: 0 16px 38px rgba(31,41,55,.1); border-color: #dadddf; }
    .catalog-image-wrap { aspect-ratio: 1 / .82; background: #f1f3f5; position: relative; overflow: hidden; display: block; }
    .catalog-image { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
    .catalog-card:hover .catalog-image { transform: scale(1.045); }
    .stock-chip { position: absolute; top: 12px; right: 12px; background: rgba(28,151,112,.93); color: #fff; border-radius: 30px; padding: 5px 10px; font-size: .74rem; font-weight: 800; }
    .stock-chip.out { background: rgba(104,113,125,.92); }
    .catalog-card-body { padding: 16px; display: flex; flex-direction: column; flex: 1; }
    .catalog-category { color: var(--primary-color); text-decoration: none; font-size: .78rem; font-weight: 800; margin-bottom: 7px; }
    .catalog-product-name { font-size: 1rem; line-height: 1.65; font-weight: 900; margin: 0 0 10px; min-height: 53px; }
    .catalog-product-name a { color: #26323d; text-decoration: none; }
    .catalog-description { color: #77818c; font-size: .84rem; line-height: 1.8; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; }
    .catalog-card-footer { margin-top: auto; padding-top: 15px; border-top: 1px solid #f0f1f3; display: flex; justify-content: space-between; align-items: center; gap: 8px; }
    .catalog-price { font-weight: 950; color: #26323d; white-space: nowrap; }
    .catalog-view { border-radius: 11px; padding: 8px 11px; color: #fff; background: var(--primary-color); text-decoration: none; font-size: .8rem; font-weight: 850; }
    .catalog-empty { background: #fff; border: 1px dashed #d9dee3; border-radius: 20px; text-align: center; padding: 70px 20px; }
    .catalog-empty i { font-size: 3rem; color: #b4bcc4; }
    .catalog-pagination { margin-top: 30px; }
    @media (max-width: 1199px) { .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 991px) {
        .catalog-layout { grid-template-columns: 1fr; }
        .desktop-filters { display: none; }
        .mobile-filter-button { display: inline-flex; align-items: center; gap: 7px; }
        .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 575px) {
        .catalog-hero { padding: 35px 0 28px; }
        .catalog-shell { padding-top: 20px; }
        .catalog-toolbar { align-items: stretch; flex-direction: column; }
        .catalog-toolbar-actions { display: flex; gap: 8px; }
        .sort-select { min-width: 0; flex: 1; }
        .product-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@php
    $resetUrl = $currentCategory
        ? route('products.categories', $currentCategory->slug)
        : route('products.index');
    $selectedAttributes = request('attributes', []);
@endphp

@section('content')
<header class="catalog-hero">
    <div class="container">
        <div class="catalog-breadcrumb"><a href="{{ route('page.home') }}">خانه</a> / <span>{{ $catalogTitle }}</span></div>
        <h1 class="catalog-title">{{ $catalogTitle }}</h1>
        <p class="catalog-subtitle">محصول مناسب را با جست‌وجو و فیلترهای دقیق سریع‌تر پیدا کنید.</p>
    </div>
</header>

<main class="catalog-shell">
    <div class="container">
        <nav class="category-strip" aria-label="دسته‌بندی محصولات">
            <a class="category-pill {{ $currentCategory ? '' : 'active' }}" href="{{ route('products.index') }}">همه محصولات</a>
            @foreach ($categories as $category)
                <a class="category-pill {{ $currentCategory?->is($category) ? 'active' : '' }}"
                   href="{{ route('products.categories', $category->slug) }}">
                    {{ $category->name }} <small>{{ number_format($category->products_count) }}</small>
                </a>
            @endforeach
        </nav>
        <div class="catalog-layout">
            <aside class="desktop-filters">
                @include('site.pages.products.partials.filters', ['formId' => 'desktopCatalogFilters'])
            </aside>

            <section aria-label="فهرست محصولات">
                <div class="catalog-toolbar">
                    <div class="catalog-count"><strong>{{ number_format($products->total()) }}</strong> محصول پیدا شد</div>
                    <div class="catalog-toolbar-actions">
                        <button class="mobile-filter-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilters"><i class="bi bi-sliders"></i>فیلتر</button>
                        <select class="sort-select" aria-label="مرتب‌سازی محصولات" data-sort-select>
                            <option value="newest" @selected($sort === 'newest')>جدیدترین</option>
                            <option value="bestselling" @selected($sort === 'bestselling')>پرفروش‌ترین</option>
                            <option value="price_low_high" @selected($sort === 'price_low_high')>ارزان‌ترین</option>
                            <option value="price_high_low" @selected($sort === 'price_high_low')>گران‌ترین</option>
                            <option value="name_az" @selected($sort === 'name_az')>نام محصول</option>
                        </select>
                    </div>
                </div>

                @if ($products->count())
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <article class="catalog-card">
                                <a class="catalog-image-wrap" href="{{ route('products.show', $product->slug) }}">
                                    <img class="catalog-image" loading="lazy"
                                        src="{{ $product->mediaFiles->firstWhere('group', 'main_image')?->full_url ?? asset('images/default-product.jpg') }}"
                                        alt="{{ $product->name }}">
                                    <span class="stock-chip {{ $product->stock > 0 ? '' : 'out' }}">{{ $product->stock > 0 ? 'موجود' : 'ناموجود' }}</span>
                                </a>
                                <div class="catalog-card-body">
                                    @if ($product->category)
                                        <a class="catalog-category" href="{{ route('products.categories', $product->category->slug) }}">{{ $product->category->name }}</a>
                                    @endif
                                    <h2 class="catalog-product-name"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h2>
                                    <p class="catalog-description">{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 95) ?: 'مشاهده مشخصات و انتخاب ترکیب مناسب محصول' }}</p>
                                    <div class="catalog-card-footer">
                                        <span class="catalog-price">{{ number_format($product->price) }} تومان</span>
                                        <a class="catalog-view" href="{{ route('products.show', $product->slug) }}">مشاهده و انتخاب</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="catalog-pagination">{{ $products->links('pagination::bootstrap-5') }}</div>
                @else
                    <div class="catalog-empty">
                        <i class="bi bi-search"></i>
                        <h2 class="h4 fw-bold mt-3">محصولی با این فیلترها پیدا نشد</h2>
                        <p class="text-muted">محدوده قیمت یا گزینه‌های انتخابی را تغییر دهید.</p>
                        <a class="btn btn-outline-dark rounded-pill px-4" href="{{ $resetUrl }}">پاک کردن فیلترها</a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</main>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilters" aria-labelledby="mobileFiltersLabel">
    <div class="offcanvas-header border-bottom">
        <h2 class="offcanvas-title h5 fw-bold" id="mobileFiltersLabel">فیلتر محصولات</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
    </div>
    <div class="offcanvas-body">
        @include('site.pages.products.partials.filters', ['formId' => 'mobileCatalogFilters', 'mobile' => true])
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-sort-select]').forEach(select => {
        select.addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    });
});
</script>
@endsection
