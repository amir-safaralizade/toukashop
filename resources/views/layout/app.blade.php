<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (View::hasSection('seo'))
        @yield('seo')
    @else
        <title>@yield('title', 'توکا پت | فروشگاه آنلاین لوازم حیوانات شما ')</title>
    @endif
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.rtl.min.css') }}">
    <!-- Font Awesome -->
    <script src="{{ asset('site/js/all.min.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('site/css/swiper-bundle.min.css') }}">
    
    
    <link rel="stylesheet" href="{{ asset('site/style.css') . '?v=' . filemtime(public_path('site/style.css')) }}">
    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="/favicons/site.webmanifest" />
	<link href="{{ asset('site/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        :root { --nav-height: 78px; --primary-color:#e94560; --secondary-color:#2ab7a5; --surface:#fff; --surface-soft:#f7f8fa; --ink:#26323c; --muted:#707b85; --border:#e5e9ec; --radius:16px; }
        html { scroll-behavior:smooth; }
        body { padding-top: var(--nav-height); background:var(--surface-soft); color:var(--ink); line-height:1.75; }
        ::selection { color:#fff; background:var(--primary-color); }
        a, button, input, select, textarea { transition:border-color .2s,box-shadow .2s,background-color .2s,color .2s,transform .2s; }
        .container { --bs-gutter-x: 1.6rem; }
        .btn { border-radius:12px; font-weight:800; padding:.62rem 1rem; }
        .btn-primary { color:#fff; border-color:var(--primary-color); background:var(--primary-color); }
        .btn-primary:hover,.btn-primary:focus { color:#fff; border-color:#d93652; background:#d93652; transform:translateY(-1px); }
        .btn-outline-primary { color:var(--primary-color); border-color:var(--primary-color); }
        .btn-outline-primary:hover { color:#fff; background:var(--primary-color); }
        .form-control,.form-select { min-height:46px; border-color:var(--border); border-radius:12px; background-color:#fff; }
        .form-control:focus,.form-select:focus { border-color:var(--primary-color); box-shadow:0 0 0 .22rem rgba(233,69,96,.1); }
        .card { border-color:var(--border); border-radius:18px; box-shadow:0 8px 28px rgba(31,41,55,.05); }
        .dropdown-menu { border-color:var(--border)!important; }
        .store-navbar { background: rgba(255,255,255,.97); border-bottom: 1px solid #eef0f3; box-shadow: 0 8px 30px rgba(31,41,55,.07); min-height: var(--nav-height); backdrop-filter: blur(12px); }
        .store-navbar .navbar-brand img { width: 74px; height: 52px; object-fit: contain; }
        .store-navbar .nav-link { color: #25313c; font-weight: 700; border-radius: 12px; padding: .65rem .8rem !important; margin: 0 .1rem; }
        .store-navbar .nav-link:hover, .store-navbar .nav-link.active { color: var(--primary-color); background: rgba(233,69,96,.08); }
        .store-search { position: relative; width: min(390px, 34vw); }
        .store-search-input { width: 100%; height: 44px; border: 1px solid #e1e5ea; border-radius: 14px; padding: 0 44px 0 42px; background: #f7f8fa; outline: none; transition: .2s; }
        .store-search-input:focus { background: #fff; border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(233,69,96,.1); }
        .store-search-icon { position: absolute; right: 15px; top: 12px; color: #7b8490; pointer-events: none; }
        .store-search-clear { position: absolute; left: 9px; top: 7px; border: 0; background: transparent; color: #7b8490; width: 30px; height: 30px; display: none; }
        .live-search-results { position: absolute; top: calc(100% + 10px); right: 0; left: 0; background: #fff; border: 1px solid #e8ebef; border-radius: 16px; box-shadow: 0 18px 45px rgba(31,41,55,.16); max-height: 430px; overflow-y: auto; padding: 8px; display: none; z-index: 1100; }
        .live-search-results.show { display: block; }
        .live-search-item { display: grid; grid-template-columns: 54px 1fr auto; gap: 10px; align-items: center; padding: 9px; color: #25313c; text-decoration: none; border-radius: 12px; }
        .live-search-item:hover, .live-search-item:focus { background: #f7f8fa; color: var(--primary-color); }
        .live-search-item img { width: 54px; height: 54px; object-fit: cover; border-radius: 10px; background: #f1f3f5; }
        .live-search-name { font-weight: 800; display: block; line-height: 1.5; }
        .live-search-meta { color: #7b8490; font-size: .78rem; }
        .live-search-price { white-space: nowrap; font-size: .82rem; font-weight: 800; }
        .nav-icon-btn { width: 44px; height: 44px; border: 1px solid #e1e5ea; color: #25313c; border-radius: 13px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; position: relative; background: #fff; }
        .nav-icon-btn:hover { color: var(--primary-color); border-color: var(--primary-color); }
        .store-navbar .cart-badge { position: absolute; top: -6px; left: -6px; min-width: 21px; height: 21px; border-radius: 20px; padding: 0 5px; display: grid; place-items: center; background: var(--primary-color); color: #fff; font-size: .7rem; font-weight: 800; }
        footer { background:linear-gradient(145deg,#202d35,#121c22); padding-top:64px; }
        footer p,footer li { color:#cbd3d8; }
        footer .footer-links a { color:#d9dfe2; }
        footer .footer-links a:hover { color:#fff; }
        footer .social-icons a { background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.1); }
        @media (max-width: 991.98px) {
            :root { --nav-height: 68px; }
            .store-navbar { min-height: var(--nav-height); }
            .store-navbar .navbar-collapse { padding: 14px 0 8px; }
            .store-search { width: 100%; margin: 10px 0 14px; }
            .store-navbar .navbar-nav { gap: 4px; }
            .store-navbar-actions { justify-content: space-between; }
        }
    </style>

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top store-navbar" aria-label="ناوبری اصلی">
        <div class="container">
            <a class="navbar-brand" href="{{ route('page.home') }}">
                <img src="{{ site_setting('logo', 'site/logos/black-logo-min.png') }}" alt="فروشگاه توکا پت">
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="باز کردن منو">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('page.home') ? 'active' : '' }}"
                            href="{{ route('page.home') }}">خانه</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') || request()->is('products*') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">محصولات</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">دسته‌بندی‌ها</a>
                        <ul class="dropdown-menu border-0 shadow rounded-4 p-2">
                            @foreach (get_product_categoris() as $navCategory)
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('products.categories', $navCategory->slug) }}">{{ $navCategory->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.about_us') }}">درباره ما</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('posts.*') || request()->is('posts*') ? 'active' : '' }}"
                            href="{{ route('posts.index') }}">وبلاگ</a></li>
                </ul>

                <form class="store-search mx-lg-auto" action="{{ route('products.index') }}" method="GET" role="search" autocomplete="off">
                    <i class="bi bi-search store-search-icon"></i>
                    <input class="store-search-input" id="liveProductSearch" type="search" name="query"
                        value="{{ request('query') }}" placeholder="جست‌وجوی محصول یا دسته‌بندی…" aria-label="جست‌وجوی محصولات"
                        aria-controls="liveSearchResults" aria-autocomplete="list">
                    <button class="store-search-clear" id="clearLiveSearch" type="button" aria-label="پاک کردن جست‌وجو"><i class="bi bi-x-lg"></i></button>
                    <div class="live-search-results" id="liveSearchResults" role="listbox"></div>
                </form>

                <div class="d-flex align-items-center gap-2 store-navbar-actions">
                    @if (auth()->check() && !auth()->user()->is_guest)
                        <a href="{{ route('account.index') }}" class="nav-icon-btn" title="حساب کاربری" aria-label="حساب کاربری"><i class="bi bi-person-check"></i></a>
                        <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="nav-icon-btn border-0" title="خروج" aria-label="خروج"><i class="bi bi-box-arrow-left"></i></button>
                        </form>
                    @else
                        <a href="{{ route('auth.login-view') }}" class="nav-icon-btn" title="ورود" aria-label="ورود"><i class="bi bi-person"></i></a>
                    @endif
                    <a href="{{ route('cart.mycart') }}" class="nav-icon-btn" aria-label="سبد خرید">
                        <i class="bi bi-cart3"></i>
                        <span class="cart-badge" id="touka_cart_items_count">{{ $cartItemCount }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-logo">
                        <img src="{{ site_setting('logo', 'site/logos/black-logo-min.png') }}" alt="toukashop Logo" width="80px">
                        <a referrerpolicy='origin' target='_blank'
                            href='https://trustseal.enamad.ir/?id=647409&Code=rQChuLlTGm7dyB07eVp7fZ6W6RBSsHqn'><img
                                referrerpolicy='origin'
                                src='https://trustseal.enamad.ir/logo.aspx?id=647409&Code=rQChuLlTGm7dyB07eVp7fZ6W6RBSsHqn'
                                alt='' style='cursor:pointer' code='rQChuLlTGm7dyB07eVp7fZ6W6RBSsHqn'></a>
                    </div>
                    <p class="mb-4">ما در توکا پت با عشق به حیوانات و تعهد به کیفیت، بهترین محصولات را برای حیوانات
                        خانگی شما ارائه می‌دهیم.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-telegram"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>لینک‌های سریع</h5>
                        <ul>
                            <li><a href="{{ route('page.home') }}">خانه</a></li>
                            <li><a href="{{ route('products.index') }}">محصولات</a></li>
                            <li><a href="{{ route('posts.index') }}">وبلاگ</a></li>
                            <li><a href="{{ route('page.about_us') }}">درباره ما</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>دسته‌بندی‌ها</h5>
                        <ul>
                            @foreach (get_product_categoris() as $item)
                                <li><a href="{{ route('products.categories', $item->slug) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="footer-links">
                        <h5>تماس با ما</h5>
                        <ul>
                            <li><i class="bi bi-geo-alt-fill me-2"></i>{{ site_setting('address') }}</li>
                            <li><i class="bi bi-telephone-fill me-2"></i>  {{ site_setting('contact-number-one') }}</li>
                            <li><i class="bi bi-instagram me-2"></i>touca_petshop</li>
                            <li><i class="bi bi-clock-fill me-2"></i> هر روز از ۹ صبح تا ۹ شب</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">© 1404 توکا پت شاپ. تمام حقوق محفوظ است.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">طراحی شده با <i class="bi bi-heart-fill text-danger"></i> برای حیوانات
                        دوست‌داشتنی</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- اسکریپت های Bootstrap -->
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('site/js/swiper-bundle.min.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'موفقیت',
            text: '{{ session('success') }}'
            });
            </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'خطا',
                text: '{{ session('warning') }}'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('liveProductSearch');
            const results = document.getElementById('liveSearchResults');
            const clearButton = document.getElementById('clearLiveSearch');
            if (!input || !results || !clearButton) return;

            let timer = null;
            let request = null;
            const endpoint = @json(route('api.products.search'));
            const allProductsUrl = @json(route('products.index'));

            const closeResults = () => results.classList.remove('show');
            const escapeHtml = value => String(value).replace(/[&<>'"]/g, char => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
            })[char]);

            function render(items, query) {
                if (!items.length) {
                    results.innerHTML = '<div class="text-center text-muted p-3">محصولی پیدا نشد</div>';
                } else {
                    results.innerHTML = items.map(item => `
                        <a class="live-search-item" role="option" href="${escapeHtml(item.url)}">
                            <img src="${escapeHtml(item.image)}" alt="">
                            <span><span class="live-search-name">${escapeHtml(item.name)}</span><span class="live-search-meta">${escapeHtml(item.category || 'بدون دسته‌بندی')}</span></span>
                            <span class="live-search-price">${new Intl.NumberFormat('fa-IR').format(item.price)} تومان</span>
                        </a>`).join('') + `
                        <a class="d-block text-center text-decoration-none fw-bold p-2" href="${allProductsUrl}?query=${encodeURIComponent(query)}">مشاهده همه نتایج</a>`;
                }
                results.classList.add('show');
            }

            input.addEventListener('input', function() {
                const query = this.value.trim();
                clearButton.style.display = query ? 'block' : 'none';
                clearTimeout(timer);
                request?.abort();
                if (query.length < 2) {
                    results.innerHTML = query ? '<div class="text-center text-muted p-3">حداقل دو حرف وارد کنید</div>' : '';
                    query ? results.classList.add('show') : closeResults();
                    return;
                }

                timer = setTimeout(async () => {
                    request = new AbortController();
                    results.innerHTML = '<div class="text-center text-muted p-3"><span class="spinner-border spinner-border-sm ms-2"></span>در حال جست‌وجو…</div>';
                    results.classList.add('show');
                    try {
                        const response = await fetch(`${endpoint}?q=${encodeURIComponent(query)}`, {signal: request.signal, headers: {'Accept': 'application/json'}});
                        if (!response.ok) throw new Error();
                        render(await response.json(), query);
                    } catch (error) {
                        if (error.name !== 'AbortError') results.innerHTML = '<div class="text-center text-danger p-3">جست‌وجو انجام نشد؛ دوباره تلاش کنید.</div>';
                    }
                }, 280);
            });

            input.addEventListener('focus', () => { if (results.innerHTML) results.classList.add('show'); });
            clearButton.addEventListener('click', () => { input.value = ''; clearButton.style.display = 'none'; closeResults(); input.focus(); });
            document.addEventListener('click', event => { if (!event.target.closest('.store-search')) closeResults(); });
            document.addEventListener('keydown', event => { if (event.key === 'Escape') closeResults(); });
            clearButton.style.display = input.value ? 'block' : 'none';
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate__animated');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.getAttribute('data-animation');
                        entry.target.classList.add('animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>


    @yield('scripts')
</body>

</html>
