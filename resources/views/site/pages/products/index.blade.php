@extends('layout.app')

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            color: var(--dark-color);
            overflow-x: hidden;
            padding-top: 80px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 900;
            color: var(--primary-color);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark-color);
            margin: 0 10px;
            position: relative;
            padding: 5px 0;
        }

        .nav-link:after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            right: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            width: 100%;
            left: 0;
        }

        .archive-header {
            background: linear-gradient(135deg,
                    rgba(78, 205, 196, 0.8) 0%,
                    rgba(255, 107, 107, 0.8) 100%),
                url("site/images/photo-1594149929911-78975a43d4f5.jpeg") no-repeat center center;
            background-size: cover;
            padding: 80px 0;
            color: white;
            text-align: center;
            margin-bottom: 50px;
            border-radius: 0 0 20px 20px;
        }

        .category-tabs {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            justify-content: flex-start;
            gap: 15px;
            margin-bottom: 40px;
            padding: 20px 15px;
            scrollbar-width: thin;
            /* نمایش اسکرول بار در دسکتاپ */
            scrollbar-color: var(--primary-color) #f1f1f1;
            /* رنگ اسکرول بار */
            -ms-overflow-style: auto;
            /* نمایش اسکرول بار در IE */
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            position: relative;
            background: linear-gradient(90deg,
                    transparent 0%,
                    transparent 95%,
                    rgba(78, 205, 196, 0.1) 100%);
        }

        /* استایل اسکرول بار برای مرورگرهای وبکیت */
        .category-tabs::-webkit-scrollbar {
            height: 6px;
            display: block;
            /* نمایش در دسکتاپ */
        }

        .category-tabs::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .category-tabs::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .category-tabs::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* نشانگر اسکرول‌پذیری */
        .category-tabs::before {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234ECDC4'%3E%3Cpath d='M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.7;
            animation: bounceHint 2s infinite;
            pointer-events: none;
            display: none;
            /* مخفی در دسکتاپ */
        }

        @keyframes bounceHint {

            0%,
            100% {
                transform: translateY(-50%) translateX(0);
            }

            50% {
                transform: translateY(-50%) translateX(-5px);
            }
        }


        .category-btn {
            background: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            position: relative;
            border: 2px solid transparent;
        }

        .category-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .category-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }


        .category-icon {
            margin-left: 8px;
            font-size: 1.2rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
            padding: 20px;
        }

        /* استایل‌های کپی‌شده از صفحه اصلی برای باکس محصولات */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            height: 530px;
            display: flex;
            flex-direction: column;
            transform-origin: center;
        }

        .product-card:active {
            transform: scale(0.97);
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(78, 205, 196, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
            z-index: 1;
        }

        .product-card:hover::before {
            width: 300px;
            height: 300px;
        }

        .product-img-container {
            position: relative;
            overflow: hidden;
            height: 450px;
            transition: height 0.4s ease;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-wishlist {
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            transition: all 0.3s ease;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .product-wishlist:hover {
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .product-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 8px;
            display: block;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark-color);
            line-height: 1.4;
            height: 60px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-description {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .rating-stars {
            color: #FFD700;
            margin-left: 5px;
        }

        .rating-count {
            font-size: 0.85rem;
            color: #777;
        }

        .product-price-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .product-price {
            display: flex;
            flex-direction: column;
        }

        .current-price {
            font-weight: 900;
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
            margin-top: 2px;
        }

        .add-to-cart {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 2;
            position: relative;
        }

        .add-to-cart:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .click-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 107, 107, 0.3);
            transform: scale(0);
            animation: clickEffect 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes clickEffect {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
                padding: 10px;
            }

            .product-card {
                height: 400px;
            }

            .product-img-container {
                height: 220px;
            }

            .product-content {
                padding: 15px;
            }

            .product-title {
                font-size: 1.1rem;
                height: auto;
            }

            .current-price {
                font-size: 1.1rem;
            }

            .archive-header {
                padding: 60px 0;
            }

            .category-tabs {
                padding: 15px 10px;
                gap: 10px;
                margin-bottom: 30px;
                scrollbar-width: none;
                /* مخفی کردن اسکرول بار در موبایل */
            }

            .category-tabs::-webkit-scrollbar {
                display: none;
                /* مخفی کردن اسکرول بار در موبایل */
            }

            .category-tabs::before {
                display: block;
                /* نمایش نشانگر در موبایل */
            }

            .category-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .category-tabs {
                gap: 8px;
                padding: 12px 8px;
            }

            .category-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .category-icon {
                font-size: 1rem;
                margin-left: 6px;
            }


            .category-tabs-container {
                position: relative;
                overflow: hidden;
            }

            .category-tabs-container::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                width: 40px;
                background: linear-gradient(90deg,
                        transparent 0%,
                        rgba(248, 249, 250, 0.8) 50%,
                        #f8f9fa 100%);
                pointer-events: none;
                z-index: 1;
                transition: opacity 0.3s ease;
            }

            /* نشان دادن گرادیانت فقط وقتی اسکرول امکان‌پذیر است */
            .category-tabs:not(.at-end)::after {
                opacity: 1;
            }

            .category-tabs.at-end::after {
                opacity: 0;
            }


        }

        .pet-icon {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.1;
            z-index: -1;
        }

        /* Animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }


        .sorting-filters {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sort-btn {
            background: white;
            border: 2px solid #e9ecef;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .sort-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .sort-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .sort-icon {
            margin-left: 8px;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .sorting-filters {
                flex-direction: column;
                align-items: center;
            }

            .sort-btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Floating pet icons -->
    <i class="bi bi-egg-fried pet-icon floating" style="top: 15%; left: 5%; animation-delay: 0.2s"></i>
    <i class="bi bi-bone pet-icon floating" style="top: 80%; right: 10%; animation-delay: 0.5s"></i>
    <i class="bi bi-balloon-heart pet-icon floating" style="top: 40%; right: 5%; animation-delay: 0.7s"></i>
    <i class="bi bi-gem pet-icon floating" style="bottom: 10%; left: 15%; animation-delay: 0.3s"></i>

    <!-- Archive Header -->
    <div class="archive-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">همه محصولات</h1>
            <p class="lead mb-0">
                بهترین و شیک‌ترین محصولات برای حیوانات خانگی دوست‌داشتنی شما
            </p>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="container">
        <div class="category-tabs-container">
            <div class="category-tabs">
                <a class="btn category-btn active" href="{{ route('products.index') }}">
                    <i class="bi bi-grid category-icon"></i>همه محصولات
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.categories', $category->slug) }}" class="btn category-btn ">
                        <i class="bi bi-bag category-icon"></i>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>


    <div class="container">
        <div class="sorting-filters">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                class="sort-btn {{ $sort == 'newest' ? 'active' : '' }}">
                <i class="bi bi-clock-history sort-icon"></i>جدیدترین
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'bestselling']) }}"
                class="sort-btn {{ $sort == 'bestselling' ? 'active' : '' }}">
                <i class="bi bi-trophy sort-icon"></i>پرفروش‌ترین
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low_high']) }}"
                class="sort-btn {{ $sort == 'price_low_high' ? 'active' : '' }}">
                <i class="bi bi-arrow-up sort-icon"></i>قیمت (کم به زیاد)
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high_low']) }}"
                class="sort-btn {{ $sort == 'price_high_low' ? 'active' : '' }}">
                <i class="bi bi-arrow-down sort-icon"></i>قیمت (زیاد به کم)
            </a>
        </div>
    </div>


    <!-- Products Grid -->
    <div class="container">
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card animate__animated animate__fadeInUp" data-category="cats,food">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-link"></a>
                    <div class="product-badge">پرفروش</div>
                    <div class="product-img-container">
                        <img src="{{ asset($product->firstMedia('main_image')->full_url) }}" class="product-img"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span class="rating-count">(42)</span>
                        </div>
                        <div class="product-price-container">
                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price) }} تومان</span>
                                <span class="old-price">{{ number_format($product->price * 1.12) }} تومان</span>
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->slug) }}" class="add-to-cart">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav> --}}
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');
            const categoryTabs = document.querySelector('.category-tabs');
            const categoryTabsContainer = document.querySelector('.category-tabs-container');

            // افکت کلیک برای محصولات
            productCards.forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.product-wishlist') || e.target.closest('.add-to-cart')) {
                        return;
                    }

                    const effect = document.createElement('div');
                    effect.className = 'click-effect';
                    effect.style.width = '100px';
                    effect.style.height = '100px';
                    effect.style.left = e.offsetX - 50 + 'px';
                    effect.style.top = e.offsetY - 50 + 'px';
                    this.appendChild(effect);

                    setTimeout(() => {
                        effect.remove();
                    }, 600);

                    const productLink = this.querySelector('a.product-link');
                    if (productLink) {
                        setTimeout(() => {
                            window.location.href = productLink.href;
                        }, 300);
                    }
                });
            });

            // اسکرول بهبود یافته برای دسته‌بندی‌ها
            if (categoryTabs) {
                let startX, scrollLeft, isDown = false;

                // اسکرول با ماوس برای دسکتاپ و موبایل
                categoryTabs.addEventListener('wheel', function(e) {
                    e.preventDefault();

                    // تشخیص جهت اسکرول و تنظیم سرعت
                    const scrollAmount = e.deltaY * (window.innerWidth <= 768 ? 0.5 : 1);
                    this.scrollLeft += scrollAmount;

                    updateScrollIndicator();
                }, {
                    passive: false
                });

                // اسکرول تاچ برای موبایل
                categoryTabs.addEventListener('touchstart', function(e) {
                    isDown = true;
                    startX = e.touches[0].pageX - this.offsetLeft;
                    scrollLeft = this.scrollLeft;
                });

                categoryTabs.addEventListener('touchmove', function(e) {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - this.offsetLeft;
                    const walk = (x - startX) * 2;
                    this.scrollLeft = scrollLeft - walk;
                    updateScrollIndicator();
                });

                categoryTabs.addEventListener('touchend', function() {
                    isDown = false;
                });

                // اسکرول با drag ماوس برای دسکتاپ
                categoryTabs.addEventListener('mousedown', function(e) {
                    isDown = true;
                    startX = e.pageX - this.offsetLeft;
                    scrollLeft = this.scrollLeft;
                    this.style.cursor = 'grabbing';
                });

                categoryTabs.addEventListener('mouseleave', function() {
                    isDown = false;
                    this.style.cursor = 'grab';
                });

                categoryTabs.addEventListener('mouseup', function() {
                    isDown = false;
                    this.style.cursor = 'grab';
                });

                categoryTabs.addEventListener('mousemove', function(e) {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - this.offsetLeft;
                    const walk = (x - startX) * 2;
                    this.scrollLeft = scrollLeft - walk;
                    updateScrollIndicator();
                });

                // نشانگر وضعیت اسکرول
                function updateScrollIndicator() {
                    const maxScroll = categoryTabs.scrollWidth - categoryTabs.clientWidth;
                    const currentScroll = categoryTabs.scrollLeft;

                    if (currentScroll >= maxScroll - 10) {
                        categoryTabs.classList.add('at-end');
                    } else {
                        categoryTabs.classList.remove('at-end');
                    }
                }

                // اسکرول خودکار به مرکز برای دکمه فعال
                function scrollActiveToCenter() {
                    const activeBtn = categoryTabs.querySelector('.category-btn.active');
                    if (activeBtn) {
                        const containerWidth = categoryTabs.offsetWidth;
                        const activeBtnLeft = activeBtn.offsetLeft;
                        const activeBtnWidth = activeBtn.offsetWidth;

                        const scrollPosition = activeBtnLeft - (containerWidth / 2) + (activeBtnWidth / 2);

                        categoryTabs.scrollTo({
                            left: scrollPosition,
                            behavior: 'smooth'
                        });
                    }
                }

                // اجرا پس از لود کامل صفحه
                setTimeout(scrollActiveToCenter, 100);

                // آپدیت نشانگر اسکرول
                categoryTabs.addEventListener('scroll', updateScrollIndicator);
                updateScrollIndicator();
            }
        });
    </script>
@endsection
