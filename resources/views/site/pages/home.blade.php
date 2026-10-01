@extends('layout.app')

@section('seo')
    <x-seo::seo-meta-display :model="$data->page" />
@endsection

@section('styles')
<style>
    .home-page { background:#f5f6f7; color:#26323c; overflow:hidden; }
    .home-slider { position:relative; background:#edf0f2; }
    .home-slider .carousel-item { height:clamp(390px,57vw,640px); }
    .home-slide-image { width:100%; height:100%; object-fit:cover; }
    .home-slide-content { position:absolute; z-index:2; top:50%; right:max(6vw,24px); width:min(540px,80%); transform:translateY(-50%); color:#fff; }
    .home-slide-content h1 { font-size:clamp(1.8rem,4.5vw,3.8rem); line-height:1.45; font-weight:950; text-shadow:0 3px 18px rgba(0,0,0,.2); }
    .home-slide-content .home-primary { margin-top:18px; background:#fff; color:#26323c; box-shadow:0 12px 32px rgba(0,0,0,.16); }
    .home-slider .carousel-control-prev,.home-slider .carousel-control-next { width:7%; }
    .home-slider .carousel-control-prev-icon,.home-slider .carousel-control-next-icon { width:44px;height:44px;border-radius:50%;background-color:rgba(20,31,37,.45);background-size:45%; }
    .home-slider .carousel-indicators [data-bs-target] { width:9px;height:9px;border:0;border-radius:99px;transition:.2s }.home-slider .carousel-indicators .active{width:28px}
    .home-primary { min-height:50px; display:inline-flex; align-items:center; justify-content:center; gap:8px; border-radius:12px; padding:0 21px; text-decoration:none; font-weight:900; transition:.2s; }
    .home-primary { color:#fff; background:#e94560; box-shadow:0 12px 26px rgba(233,69,96,.23); }
    .home-primary:hover { color:#fff; background:#d93652; transform:translateY(-2px); }
    .benefits { position:relative; z-index:4; margin-top:-1px; background:#fff; border-bottom:1px solid #edf0f2; }
    .benefits-grid { display:grid; grid-template-columns:repeat(4,1fr); }
    .benefit { display:flex; align-items:center; gap:12px; padding:22px 16px; border-left:1px solid #edf0f2; }
    .benefit:last-child { border:0; }
    .benefit-icon { width:43px; height:43px; flex:0 0 43px; display:grid; place-items:center; border-radius:13px; color:#e94560; background:#fff0f3; font-size:1.2rem; }
    .benefit strong { display:block; font-size:.88rem; }.benefit small{color:#78838d;font-size:.75rem}
    .home-section { padding:20px 0; }.home-section.soft{background:transparent}.home-section>.container{padding:24px;background:#fff;border:1px solid #e5e8eb;border-radius:16px}
    .section-head { display:flex; justify-content:space-between; align-items:end; gap:20px; margin-bottom:28px; }
    .section-eyebrow { color:#e94560; font-size:.78rem; font-weight:950; letter-spacing:.3px; }
    .section-head h2 { margin:6px 0 0; font-size:clamp(1.55rem,3vw,2.25rem); font-weight:950; }
    .section-head p { color:#74808a; margin:8px 0 0; }.section-more{color:#e94560;text-decoration:none;font-weight:900;white-space:nowrap}
    .pet-category-section { padding:32px 0; background:#fff; border-bottom:1px solid #e8ebed; }
    .pet-category-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:15px; }
    .pet-category { min-width:0; color:#28343e; text-align:center; text-decoration:none; }
    .pet-category-image { aspect-ratio:1; overflow:hidden; padding:6px; border:1px solid #e4e8eb; border-radius:50%; background:#fff; box-shadow:0 9px 25px rgba(31,41,55,.06); transition:.25s; }
    .pet-category-image img { width:100%;height:100%;object-fit:cover;border-radius:50%;background:#f1f3f4;transition:.35s}.pet-category:hover .pet-category-image{transform:translateY(-5px);border-color:#edaeba;box-shadow:0 15px 34px rgba(31,41,55,.1)}.pet-category:hover img{transform:scale(1.05)}
    .pet-category h3 { margin:12px 0 3px;font-size:.9rem;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.pet-category span{color:#7b858f;font-size:.72rem}
    .product-grid-home { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:19px; }
    .product-slider-shell { position:relative; }.home-products-slider{display:grid;grid-auto-flow:column;grid-auto-columns:minmax(220px,255px);gap:14px;overflow-x:auto;scroll-behavior:smooth;scrollbar-width:none;padding:2px}.home-products-slider::-webkit-scrollbar{display:none}.product-slider-btn{position:absolute;z-index:3;top:43%;width:42px;height:42px;display:grid;place-items:center;border:1px solid #dfe4e7;border-radius:50%;background:#fff;color:#36424c;box-shadow:0 5px 18px rgba(31,41,55,.13)}.product-slider-btn.prev{right:-15px}.product-slider-btn.next{left:-15px}.product-slider-btn:hover{color:#fff;background:#e94560;border-color:#e94560}
    .home-product { min-width:0; display:flex; flex-direction:column; overflow:hidden; border:1px solid #e6eaed; border-radius:14px; background:#fff; transition:.25s; }
    .home-product:hover { transform:translateY(-5px); border-color:#eac0c7; box-shadow:0 17px 40px rgba(31,41,55,.09); }
    .home-product-image { aspect-ratio:1/.82; position:relative; display:block; overflow:hidden; background:#f1f3f4; }
    .home-product-image img { width:100%;height:100%;object-fit:cover;transition:.35s}.home-product:hover img{transform:scale(1.045)}
    .home-chip { position:absolute; top:12px; right:12px; padding:5px 9px; border-radius:999px; color:#fff; background:rgba(30,157,116,.92); font-size:.69rem; font-weight:850; }
    .home-chip.out { background:rgba(95,105,115,.9); }
    .home-product-body { display:flex; flex-direction:column; flex:1; padding:15px; }.home-product-category{color:#e94560;font-size:.72rem;font-weight:850;text-decoration:none}.home-product h3{font-size:.94rem;line-height:1.7;font-weight:900;margin:7px 0 12px;min-height:49px}.home-product h3 a{color:#29343e;text-decoration:none}
    .variant-preview { min-height:28px; display:flex; align-items:center; flex-wrap:wrap; gap:5px; margin-bottom:11px; }.variant-dot{width:20px;height:20px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 1px #cdd3d8}.variant-text{padding:4px 7px;border-radius:8px;background:#f1f3f5;color:#68737d;font-size:.67rem;font-weight:750}
    .home-product-foot { display:flex; justify-content:space-between; align-items:center; gap:8px; padding-top:12px; margin-top:auto; border-top:1px solid #f0f2f3; }.home-price{font-size:.9rem;font-weight:950;white-space:nowrap}.product-arrow{width:35px;height:35px;display:grid;place-items:center;border-radius:11px;color:#fff;background:#e94560;text-decoration:none}
    .banner-grid { display:grid; grid-template-columns:1.35fr .65fr; gap:16px; }.home-banner{min-height:430px;position:relative;display:flex;align-items:end;overflow:hidden;border-radius:16px;background:#e9edf0 center/cover;color:#fff;text-decoration:none;transition:.2s}.home-banner:hover{color:#fff;box-shadow:0 12px 30px rgba(31,41,55,.12)}.home-banner:after{content:"";position:absolute;inset:0;background:linear-gradient(0deg,rgba(15,24,29,.78),rgba(15,24,29,.02) 72%)}.home-banner-content{position:relative;z-index:1;padding:24px}.home-banner h3{font-size:1.4rem;font-weight:950}.home-banner p{margin:5px 0 0;color:#e5eaed}.banner-side{display:grid;grid-template-rows:1fr 1fr;gap:16px}.banner-side .home-banner{min-height:0}.banner-side .home-banner-content{padding:18px}.banner-side h3{font-size:1.05rem}.banner-side p{font-size:.78rem;line-height:1.7}
    .article-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:19px}.home-article{overflow:hidden;border:1px solid #e6eaed;border-radius:22px;background:#fff}.home-article img{width:100%;aspect-ratio:1/.58;object-fit:cover;background:#eef0f2}.article-body{padding:17px}.article-body span{color:#e94560;font-size:.72rem;font-weight:850}.article-body h3{font-size:.98rem;line-height:1.8;font-weight:900;margin:7px 0}.article-body p{color:#737e88;font-size:.8rem;line-height:1.8;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.article-link{color:#e94560;text-decoration:none;font-size:.8rem;font-weight:850}
    @media(max-width:991px){.benefits-grid{grid-template-columns:repeat(2,1fr)}.product-grid-home{grid-template-columns:repeat(2,1fr)}.pet-category-grid{grid-template-columns:repeat(3,1fr)}.banner-grid{grid-template-columns:1fr}.banner-side{grid-template-columns:1fr 1fr;grid-template-rows:1fr}.banner-side .home-banner{min-height:210px}.article-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:575px){.home-slider .carousel-item{height:360px}.home-slide-content{top:auto;right:20px;bottom:48px;width:calc(100% - 40px);transform:none}.home-slide-content h1{font-size:1.75rem;text-shadow:0 2px 10px rgba(0,0,0,.65)}.home-slider .carousel-control-prev,.home-slider .carousel-control-next{display:none}.pet-category-section{padding:26px 0}.pet-category-grid{grid-template-columns:repeat(3,1fr);gap:12px}.pet-category h3{font-size:.78rem}.benefit{padding:16px 8px}.benefit small{display:none}.home-section{padding:9px 0}.home-section>.container{padding:18px 12px;border-radius:0;border-right:0;border-left:0}.section-head{align-items:flex-start}.product-grid-home{gap:9px}.home-products-slider{grid-auto-columns:minmax(190px,78vw)}.product-slider-btn{display:none}.home-product-body{padding:11px}.article-grid{grid-template-columns:1fr}.banner-side{grid-template-columns:1fr}.banner-side .home-banner{min-height:190px}}
</style>
@endsection

@section('content')
<main class="home-page">
    <section class="home-slider" aria-label="پیشنهادهای ویژه">
        <div id="homeHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5500">
            @if($data->sliders->count() > 1)<div class="carousel-indicators">@foreach($data->sliders as $slider)<button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="اسلاید {{ $loop->iteration }}"></button>@endforeach</div>@endif
            <div class="carousel-inner">
                @forelse($data->sliders as $slider)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}"><img class="home-slide-image" src="{{ get_full_url($slider->image) }}" alt="{{ $slider->title ?: 'پیشنهاد ویژه توکا' }}"><div class="home-slide-content">@if($slider->title)<h1>{{ $slider->title }}</h1>@endif<a class="home-primary" href="{{ $slider->link ?: route('products.index') }}">مشاهده محصولات <i class="bi bi-arrow-left"></i></a></div></div>
                @empty
                    <div class="carousel-item active"><div class="home-slide-image" style="background:linear-gradient(135deg,#e94560,#2ab7a5)"></div><div class="home-slide-content"><h1>محصول مناسب دوست کوچکت را پیدا کن</h1><a class="home-primary" href="{{ route('products.index') }}">مشاهده محصولات</a></div></div>
                @endforelse
            </div>
            @if($data->sliders->count() > 1)<button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">قبلی</span></button><button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">بعدی</span></button>@endif
        </div>
    </section>

    <section class="pet-category-section" id="homeCategories"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">برای چه دوستی خرید می‌کنی؟</span><h2>دسته‌بندی‌های محبوب</h2></div><a class="section-more" href="{{ route('products.index') }}">همه محصولات <i class="bi bi-arrow-left"></i></a></div>
        <div class="pet-category-grid">@foreach($data->animal_tags as $tag) @php($tagImage=$tag->firstMedia('tags_main_image')) <a class="pet-category" href="{{ route('products.tag',$tag->slug) }}"><div class="pet-category-image"><img src="{{ $tagImage?->full_url ?? asset('images/default-product.jpg') }}" alt="{{ $tag->name }}"></div><h3>{{ $tag->name }}</h3><span>{{ number_format($tag->products_count) }} محصول</span></a>@endforeach</div>
    </div></section>

    <section class="benefits"><div class="container"><div class="benefits-grid">
        <div class="benefit"><span class="benefit-icon"><i class="bi bi-box-seam"></i></span><div><strong>تنوع واقعی کالا</strong><small>مدل‌های مناسب نیازهای مختلف</small></div></div>
        <div class="benefit"><span class="benefit-icon"><i class="bi bi-palette"></i></span><div><strong>انتخاب رنگ و سایز</strong><small>موجودی دقیق برای هر ترکیب</small></div></div>
        <div class="benefit"><span class="benefit-icon"><i class="bi bi-credit-card"></i></span><div><strong>پرداخت امن</strong><small>فرایند ساده و قابل پیگیری</small></div></div>
        <div class="benefit"><span class="benefit-icon"><i class="bi bi-headset"></i></span><div><strong>پشتیبانی خرید</strong><small>همراه شما برای انتخاب بهتر</small></div></div>
    </div></div></section>

    @if($data->banners->isNotEmpty())
    <section class="home-section soft"><div class="container"><div class="banner-grid">
        @php($mainBanner=$data->banners->first())
        <a class="home-banner" href="{{ $mainBanner->link ?: route('products.index') }}" style="background-image:url('{{ get_full_url($mainBanner->image) }}')"><div class="home-banner-content"><h3>{{ $mainBanner->title }}</h3><p>{{ $mainBanner->description }}</p></div></a>
        <div class="banner-side">@foreach($data->banners->skip(1) as $banner)<a class="home-banner" href="{{ $banner->link ?: route('products.index') }}" style="background-image:url('{{ get_full_url($banner->image) }}')"><div class="home-banner-content"><h3>{{ $banner->title }}</h3><p>{{ $banner->description }}</p></div></a>@endforeach</div>
    </div></div></section>
    @endif

    @foreach($data->product_sections as $section)
    <section class="home-section"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">پیشنهادهای توکا</span><h2>{{ $section->title }}</h2></div><a class="section-more" href="{{ route('products.index') }}">مشاهده همه <i class="bi bi-arrow-left"></i></a></div>
        @include('site.pages.products.partials.home-grid',['homeProducts'=>$section->display_products,'badge'=>'پیشنهادی','sliderMode'=>true])
    </div></section>
    @endforeach

    <section class="home-section"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">انتخاب مشتری‌ها</span><h2>محصولات محبوب</h2><p>گزینه‌هایی که بیشتر مورد توجه قرار گرفته‌اند.</p></div><a class="section-more" href="{{ route('products.index',['sort'=>'bestselling']) }}">مشاهده بیشتر <i class="bi bi-arrow-left"></i></a></div>
        @include('site.pages.products.partials.home-grid',['homeProducts'=>$data->products,'badge'=>'محبوب'])
    </div></section>

    @if($data->variety_products->isNotEmpty())
    <section class="home-section"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">انتخاب‌های بیشتر</span><h2>محصولات دارای رنگ و مدل متنوع</h2><p>موجودی هر رنگ، سایز و مدل را در صفحه محصول ببین.</p></div><a class="section-more" href="{{ route('products.index',['in_stock'=>1]) }}">مشاهده همه <i class="bi bi-arrow-left"></i></a></div>
        @include('site.pages.products.partials.home-grid',['homeProducts'=>$data->variety_products,'badge'=>'چندمدلی'])
    </div></section>
    @endif

    <section class="home-section"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">تازه رسیده‌ها</span><h2>جدیدترین محصولات</h2><p>آخرین انتخاب‌هایی که به فروشگاه اضافه شده‌اند.</p></div><a class="section-more" href="{{ route('products.index',['sort'=>'newest']) }}">همه تازه‌ها <i class="bi bi-arrow-left"></i></a></div>
        @include('site.pages.products.partials.home-grid',['homeProducts'=>$data->new_products,'badge'=>'جدید'])
    </div></section>

    @if($data->posts->isNotEmpty())
    <section class="home-section soft"><div class="container">
        <div class="section-head"><div><span class="section-eyebrow">راهنمای نگهداری</span><h2>مطالب تازه و کاربردی</h2><p>برای مراقبت بهتر و انتخاب آگاهانه‌تر بخوان.</p></div><a class="section-more" href="{{ route('posts.index') }}">همه مطالب <i class="bi bi-arrow-left"></i></a></div>
        <div class="article-grid">@foreach($data->posts as $post) @php($image=$post->firstMedia('main_image')) <article class="home-article"><a href="{{ route('posts.show',$post->slug) }}"><img loading="lazy" src="{{ $image?->full_url ?? asset('images/default-product.jpg') }}" alt="{{ $post->title }}"></a><div class="article-body"><span>{{ $post->category?->name ?? 'مجله توکا' }}</span><h3>{{ $post->title }}</h3><p>{{ $post->summary }}</p><a class="article-link" href="{{ route('posts.show',$post->slug) }}">ادامه مطلب <i class="bi bi-arrow-left"></i></a></div></article>@endforeach</div>
    </div></section>
    @endif
</main>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.product-slider-shell').forEach(shell => {
    const track = shell.querySelector('[data-products-track]');
    shell.querySelector('[data-slider-prev]')?.addEventListener('click', () => track.scrollBy({left: track.clientWidth * .8, behavior: 'smooth'}));
    shell.querySelector('[data-slider-next]')?.addEventListener('click', () => track.scrollBy({left: -track.clientWidth * .8, behavior: 'smooth'}));
});
</script>
@endsection
