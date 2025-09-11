<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('seo')
    <title>@yield('title', 'فروشگاه کفش ونل')</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.rtl.min.css') }}">
    <!-- Font Awesome -->
    <script src="{{ asset('site/js/all.min.js') }}"></script>
    <link href="{{ asset('site/css/bootstrap-icons.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('site/css/swiper-bundle.min.css') }}">

    <link rel="stylesheet" href="{{ asset('site/style.css') . '?v=' . time() }}">
    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="/favicons/site.webmanifest" />
    @yield('styles')
</head>

<body>

    @php
        $categories = \App\Models\Category::where('type', 'product')->get();
    @endphp
    <header class="vannel-header">
        <div class="header-container container">
            <!-- لوگو -->
            <a href="{{ route('page.home') }}" class="header-logo">
                <img src="{{ asset('site/logos/black-logo-min.png') }}" alt="ونل">
                <span class="header-logo-text">ونل</span>
            </a>

            <!-- منوی اصلی -->
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('page.home') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>صفحه اصلی</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-shoe-prints"></i>
                            <span>محصولات</span>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('products.index') }}" class="submenu-link">
                                    همه محصولات
                                </a>
                            </li>
                            @foreach ($categories as $item)
                                <li>
                                    <a href="{{ route('products.categories', $item->slug) }}" class="submenu-link">
                                        {{ $item->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('products.index') . '?category=2' }}" class="nav-link">
                            <i class="fas fa-fire"></i>
                            <span>پرفروش‌ها</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('page.size-selection-guide') }}" class="nav-link">
                            <i class="fas fa-user-astronaut"></i>
                            <span>راهنمای انتخاب سایز</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- جستجو -->
            <div class="search-container">
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <input type="text" name="query" class="search-input" placeholder="جستجوی محصولات..."
                        autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search search-icon"></i>
                    </button>
                </form>
                <div class="search-results"></div>
            </div>

            <!-- اقدامات -->
            <div class="header-actions">
                <div class="action-btn" id="search-toggle">
                    <i class="fas fa-search"></i>
                </div>

                <div>
                    <a href="{{ route('auth.login-view') }}" target="_blank" class="btn btn-dark">ورود/عضویت</a>
                </div>

                <a href="{{ route('cart.mycart') }}" class="action-btn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="action-count cart-count">{{ $cartItemCount }}</span>
                </a>

                <div class="mobile-toggle" id="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>

        <!-- منوی موبایل -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-search">
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <input type="text" name="query" class="search-input" placeholder="جستجو در ونل..."
                        autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="search-results"></div>
            </div>

            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a href="{{ route('page.home') }}" class="mobile-nav-link">
                        <span><i class="fas fa-home"></i> صفحه اصلی</span>
                    </a>
                </li>

                <li class="mobile-nav-item">
                    <div class="mobile-nav-link" id="mobile-products-toggle">
                        <span><i class="fas fa-shoe-prints"></i> محصولات</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="mobile-submenu" id="mobile-products-submenu">
                        <li>
                            <a href="{{ route('products.index') }}" class="mobile-submenu-link">
                                همه محصولات
                            </a>
                        </li>
                        @foreach ($categories as $item)
                            <li>
                                <a href="{{ route('products.index') . '?category=' . $item->id }}"
                                    class="mobile-submenu-link">
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="mobile-nav-item">
                    <a href="{{ route('products.index') . '?category=2' }}" class="mobile-nav-link">
                        <span><i class="fas fa-fire"></i> پرفروش‌ها</span>
                    </a>
                </li>

                <li class="mobile-nav-item">
                    <a href="{{ route('page.size-selection-guide') }}" class="mobile-nav-link">
                        <span><i class="fas fa-user-astronaut"></i> راهنمای انتخاب سایز</span>
                    </a>
                </li>
            </ul>

            <div class="mobile-actions">

                <div>
                    <a href="#" target="_blank" class="btn btn-dark">ورود/عضویت</a>
                </div>

                <a href="{{ route('cart.mycart') }}" class="action-btn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="action-count cart-count">{{ $cartItemCount }}</span>
                </a>

                <a href="#" class="action-btn">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>

        <!-- overlay -->
        <div class="overlay" id="overlay"></div>
    </header>
    <div id="header-spacer" style="height: 80px;"></div>

    <div class="balance"></div>

    @yield('content')

    <!-- فوتر -->
    <footer id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 fade-in">
                    <a class="footer-logo" href="#">
                        <a referrerpolicy='origin' target='_blank'
                            href='https://trustseal.enamad.ir/?id=623230&Code=kGjmCgQWIn3GZg5KV59HZSQ0BHIvCG0U'><img
                                referrerpolicy='origin'
                                src='https://trustseal.enamad.ir/logo.aspx?id=623230&Code=kGjmCgQWIn3GZg5KV59HZSQ0BHIvCG0U'
                                alt='' style='cursor:pointer' code='kGjmCgQWIn3GZg5KV59HZSQ0BHIvCG0U'></a>
                    </a>
                    <a onclick="window.open('https://panel.aqayepardakht.ir/trustGateway/58244',null,'width=400, height=600, scrollbars=no, resizable=no')"
                        href="javascript:void(0)" referrerpolicy="strict-origin-when-cross-origin"
                        title="پرداخت امن آقای پرداخت">
                        <img style="border-radius: 0px;margin-right: 10px;"
                            src="https://panel.aqayepardakht.ir/trustlogo/1.svg" alt="پرداخت امن آقای پرداخت"></a>


                    <p>
                        ونل یک فروشگاه کفش ایرانی است که با هدف ارائه محصولات باکیفیت و
                        طراحی‌های مدرن برای نسل جوان تأسیس شده است. ما به جزئیات اهمیت
                        می‌دهیم و هر جفت کفش را با دقت و عشق برای شما به ارمغان میاوریم.
                    </p>
                    <div class="social-icons mt-4">
                        <a href="instagram://user?username=vanell.ir"><i class="bi bi-instagram"></i></a>
                        {{--                    <a href="#"><i class="bi bi-telegram"></i></a> --}}
                        {{--                    <a href="#"><i class="bi bi-twitter-x"></i></a> --}}
                        {{--                    <a href="#"><i class="bi bi-spotify"></i></a> --}}
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 fade-in delay-1">
                    <div class="footer-links">
                        <h4>لینک‌ها</h4>
                        <ul>
                            <li><a href="{{ route('page.home') }}">صفحه اصلی</a></li>
                            <li><a href="{{ route('products.index') }}">محصولات</a></li>
                            <li><a href="{{ route('cart.mycart') }}">سبد خرید</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 fade-in delay-2">
                    <div class="footer-links">
                        <h4>خدمات</h4>
                        <ul>
                            <li><a href="{{ route('page.orderTracking') }}">پیگیری سفارش</a></li>
                            <li><a href="{{ route('page.size-selection-guide') }}">راهنمای اندازه</a></li>
                            <li><a href="{{ route('page.privacy') }}">حریم خصوصی</a></li>
                            <li><a href="#">سوالات متداول</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 fade-in delay-3">
                    <div class="footer-links">
                        <h4>تماس با ما</h4>
                        <ul>
                            <li>
                                <i class="bi bi-geo-alt me-2"></i> تهران، خیابان ولیعصر
                            </li>
                            <li>
                                <i class="bi bi-telephone me-2"></i>
                                0905-362-1387
                            </li>
                            <li>
                                <i class="bi bi-telephone me-2"></i>
                                0992-080-5054
                            </li>
                            <li>
                                <i class="bi bi-clock me-2"></i> شنبه تا پنجشنبه: ۹ صبح تا ۹
                                شب
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright text-center fade-in delay-4">
                <p class="mb-0">© 1404 تمام حقوق برای ونل محفوظ است.</p>
            </div>
        </div>
    </footer>

    <!-- اسکریپت های Bootstrap -->
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('site/js/swiper-bundle.min.js') }}"></script>

    @if (session('success'))
        < script>
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
        function updateHeaderSpacer() {
            const header = document.querySelector('.vannel-header');
            const spacer = document.getElementById('header-spacer');

            if (header && spacer) {
                const trueHeight = header.offsetHeight;
                spacer.style.height = `${trueHeight}px`;
            }
        }

        window.addEventListener('load', updateHeaderSpacer);
        window.addEventListener('resize', updateHeaderSpacer);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('overlay');
            const mobileProductsToggle = document.getElementById('mobile-products-toggle');
            const mobileProductsSubmenu = document.getElementById('mobile-products-submenu');
            const searchToggle = document.getElementById('search-toggle');
            const searchContainer = document.querySelector('.search-container');
            const searchInputs = document.querySelectorAll('.search-input');
            const searchForms = document.querySelectorAll('.search-form');

            mobileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = mobileMenu.classList.contains('active');
                if (isOpen) {
                    mobileMenu.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                } else {
                    mobileMenu.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });


            overlay.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                searchContainer.classList.remove('active');
            });


            mobileProductsToggle.addEventListener('click', function(e) {
                e.stopPropagation(); // جلوگیری از بسته شدن منو
                mobileProductsSubmenu.classList.toggle('active');
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });

            if (searchToggle && searchContainer) {
                searchToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    searchContainer.classList.toggle('active');
                    if (searchContainer.classList.contains('active')) {
                        searchContainer.querySelector('input').focus();
                    }
                });
            }


            window.addEventListener('scroll', function() {
                const header = document.querySelector('.vannel-header');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            document.querySelectorAll('.mobile-nav-item > a.mobile-nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    mobileMenu.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });


            searchInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const query = this.value.trim();
                    const resultsContainer = this.closest('.search-form').nextElementSibling;

                    if (query.length > 2) {
                        fetchResults(query, resultsContainer);
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                });

                input.addEventListener('focus', function() {
                    const resultsContainer = this.closest('.search-form').nextElementSibling;
                    if (this.value.trim().length > 2) {
                        resultsContainer.style.display = 'block';
                    }
                });

                input.addEventListener('blur', function() {
                    setTimeout(() => {
                        const resultsContainer = this.closest('.search-form')
                            .nextElementSibling;
                        resultsContainer.style.display = 'none';
                    }, 200);
                });
            });

            searchForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const input = this.querySelector('input[name="query"]');
                    if (input.value.trim() === '') {
                        e.preventDefault();
                        input.focus();
                    }
                });
            });
        });
    </script>


    @yield('scripts')
</body>

</html>
