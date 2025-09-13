@extends('layout.app')


@section('styles')
    <style>
        /* استایل جدید برای کارت محصولات با افکت کلیک */
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            height: 530px;
            /* ارتفاع بیشتر برای کارت */
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
            /* ارتفاع بیشتر برای تصاویر */
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

        /* افکت کلیک برای رفتن به صفحه محصول */
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
            .products-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
                padding: 10px;
            }

            .product-card {
                height: 400px;
                /* ارتفاع بیشتر برای کارت در موبایل */
            }

            .product-img-container {
                height: 220px;
                /* ارتفاع بیشتر برای تصاویر در موبایل */
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
        }


        .featured-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(78, 205, 196, 0.05) 100%);
            border-radius: 25px;
            padding: 50px;
            margin: 60px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .featured-section::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(78, 205, 196, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .featured-section::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 107, 107, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .featured-content {
            position: relative;
            z-index: 2;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            margin-bottom: 15px;
            padding-right: 30px;
            position: relative;
            font-size: 1.1rem;
        }

        .feature-list li::before {
            content: '✓';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .product-showcase {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-product {
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
        }

        .main-product:hover {
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .floating-products {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .floating-item {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .floating-item:nth-child(1) {
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-item:nth-child(2) {
            top: 60%;
            left: 5%;
            animation: float 7s ease-in-out infinite 1s;
        }

        .floating-item:nth-child(3) {
            top: 30%;
            right: 5%;
            animation: float 5s ease-in-out infinite 0.5s;
        }

        .floating-item:nth-child(4) {
            top: 70%;
            right: 15%;
            animation: float 8s ease-in-out infinite 1.5s;
        }

        .floating-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .featured-section {
                padding: 30px;
            }

            .section-title {
                font-size: 2rem;
            }

            .product-showcase {
                margin-top: 40px;
            }

            .floating-item {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content animate__animated animate__fadeIn">
            <h1>توکا پت شاپ , انتخابی مطمئن برای سلامت و شادی حیوانات</h1>
            <p>
                با خیال راحت خرید کنید! تمام لوازم حیوانات خانگی در پت‌شاپ ما توسط تیم تخصصی و دامپزشکان بررسی و انتخاب
                شده‌اند
            </p>
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">محصولات ویژه</a>
                <a href="#" class="btn btn-outline-light btn-lg">درباره ما</a>
            </div>
        </div>

        <!-- Floating pet icons -->
        <i class="bi bi-egg-fried pet-icon floating" style="top: 20%; left: 10%; animation-delay: 0.2s;"></i>
        <i class="bi bi-bone pet-icon floating" style="top: 70%; right: 15%; animation-delay: 0.5s;"></i>
        <i class="bi bi-balloon-heart pet-icon floating" style="top: 30%; right: 20%; animation-delay: 0.7s;"></i>
        <i class="bi bi-gem pet-icon floating" style="bottom: 10%; left: 20%; animation-delay: 0.3s;"></i>
    </section>

    <!-- Features Section -->
    <section class="container my-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">چرا توکا پت؟</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>کیفیت تضمینی</h4>
                    <p>تمام محصولات ما با بالاترین استانداردهای کیفیت انتخاب شده‌اند و سلامت حیوان شما را تضمین می‌کنند.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>تحویل سریع</h4>
                    <p>سفارشات شما در کمترین زمان ممکن آماده و به درب منزل شما ارسال می‌شود.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>پشتیبانی 24/7</h4>
                    <p>تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات و راهنمایی شماست.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 1 - Pet Categories -->
    <section class="creative-section">
        <div class="creative-bg" style="background-image: url('{{ asset('site/images/categoryBackgroud.jpg') }}');"></div>
        <div class="container">
            <div class="creative-content animate__animated animate__fadeIn">
                <div class="text-center mb-5">
                    <h2 class="section-title">دسته‌بندی حیوانات</h2>
                    <p class="lead">محصولات اختصاصی برای هر نوع حیوان خانگی</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <img src="{{ asset('site/images/animals/dog-solid-full.svg') }}" width="40px"
                                    alt="">
                            </div>
                            <h5>سگ‌ها</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <img src="{{ asset('site/images/animals/cat-solid-full.svg') }}" width="40px"
                                    alt="">
                            </div>
                            <h5>گربه‌ها</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <img src="{{ asset('site/images/animals/crow-solid-full.svg') }}" width="40px"
                                    alt="">
                            </div>
                            <h5>پرندگان</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <img src="{{ asset('site/images/animals/fish-solid-full.svg') }}" width="40px"
                                    alt="">
                            </div>
                            <h5>آبزیان</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">محصولات پرفروش</h2>
            <p class="lead">محصولاتی که مشتریان ما عاشقشان هستند</p>
        </div>
        <div class="products-container">
            @foreach ($data->products as $product)
                <div class="product-card animate__animated animate__fadeInUp">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-link"></a>
                    <div class="product-badge">پرفروش</div>
                    <button class="product-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <div class="product-img-container">
                        <img src="{{ asset($product->firstMedia('main_image')->full_url) }}" class="product-img"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        {{-- <p class="product-description">غذای کامل و مقوی مخصوص گربه های بالغ با طعم مرغ</p> --}}

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
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg text-dark">مشاهده همه محصولات</a>
        </div>
    </section>

    <section class="featured-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="featured-content">
                        <span class="badge">پرفروش ترین ها</span>
                        <h2 class="section-title">بهترین ظرف غذاهای حیوانات</h2>
                        <p class="section-subtitle">
                            در توکا پت شاپ، با کیفیت‌ترین و بادوام‌ترین ظرف غذاها را برای حیوانات خانگی خود پیدا کنید.
                            محصولاتی که سلامت و راحتی حیوان شما را تضمین می‌کنند.
                        </p>

                        <ul class="feature-list">
                            <li>ساخته شده از مواد باکیفیت و غیرسمی</li>
                            <li>طراحی ارگونومیک برای راحتی حیوان</li>
                            <li>قابل استفاده در ماشین ظرفشویی</li>
                            <li>ضد لغزش و مقاوم در برابر ضربه</li>
                            <li>مناسب برای تمام نژادها و سنین</li>
                            <li>طراحی شده با مشاوره دامپزشکان</li>
                        </ul>

                        <div class="mt-4">
                            <a href="#" class="btn btn-primary">مشاهده همه محصولات</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product-showcase">
                        <img src="{{asset('site/images/photo-1533738363-b7f9aef128ce.jpeg')}}"
                            alt="ظرف غذای حیوانات" class="main-product">

                        <div class="floating-products">
                            <div class="floating-item">
                                <img src="{{asset('site/images/photo-1533738363-b7f9aef128ce.jpeg')}}"
                                    alt="ظرف غذای سگ">
                            </div>
                            <div class="floating-item">
                                <img src="{{asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg')}}"
                                    alt="ظرف غذای گربه">
                            </div>
                            <div class="floating-item">
                                <img src="{{asset('site/images/photo-1552053831-71594a27632d.jpeg')}}"
                                    alt="ظرف غذای پرنده">
                            </div>
                            <div class="floating-item">
                                <img src="{{asset('site/images/p1.jpeg')}}"
                                    alt="ظرف غذای همستر">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">انواع لانه و باکس نگهداری مراقبت از حیوانات</h2>
            <p class="lead">محصولاتی که مشتریان ما عاشقشان هستند</p>
        </div>
        <div class="products-container">
            @foreach ($data->cage_products as $product)
                <div class="product-card animate__animated animate__fadeInUp">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-link"></a>
                    <div class="product-badge">پیشنهادی توکاشاپ</div>
                    <button class="product-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <div class="product-img-container">
                        <img src="{{ asset($product->firstMedia('main_image')->full_url) }}" class="product-img"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        {{-- <p class="product-description">غذای کامل و مقوی مخصوص گربه های بالغ با طعم مرغ</p> --}}

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
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg text-dark">مشاهده همه محصولات</a>
        </div>
    </section>

    <!-- Creative Section 2 - Testimonials -->
    <section class="creative-section bg-light">
        <div class="creative-bg" style="background-image: url('{{ asset('site/images/photo20788510751.jpg') }}');"></div>
        <div class="container">
            <div class="creative-content animate__animated animate__fadeIn">
                <div class="text-center mb-5">
                    <h2 class="section-title">نظرات مشتریان</h2>
                    <p class="lead">آنچه مشتریان ما درباره توکا پت می‌گویند</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/80.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">سارا محمدی</h6>
                                    <small class="text-muted">مالک گربه</small>
                                </div>
                            </div>
                            <p>محصولات توکا پت واقعا کیفیت بالایی دارند. گربه من عاشق غذای تونایی شده و هر بار با اشتها
                                می‌خوره. ممنون از خدمات عالیتون.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/12.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">امیر حسینی</h6>
                                    <small class="text-muted">مالب سگ</small>
                                </div>
                            </div>
                            <p>قلاده چرمی که خریدم واقعا لاکچریه و دوام بالایی داره. تحویل سریع و بسته‌بندی شیک هم از مزایای
                                خرید از توکا پته.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/90.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">نازنین رضایی</h6>
                                    <small class="text-muted">مالک پرنده</small>
                                </div>
                            </div>
                            <p>قفس پرنده‌ای که از توکا پت خریدم طراحی فوق‌العاده‌ای داره و واقعا برای پرنده‌ام فضای مناسبی
                                ایجاد کرده. مشاوره خوبتون هم کمک بزرگی بود.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 3 - Instagram -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">اینستاگرام ما</h2>
            <p class="lead">تصاویر حیوانات با نمک مشتریان ما را دنبال کنید</p>
        </div>
        <div class="row g-3">
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1526336024174-e58f5cdd8e13.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1594149929911-78975a43d4f5.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1552053831-71594a27632d.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1583511655826-05700d52f4d9.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="https://www.instagram.com/touca_petshop?igsh=MWQ1c24zbnowdDFuaQ%3D%3D&utm_source=qr" target="_blank"
                class="btn btn-outline-dark"><i class="bi bi-instagram me-2"></i>صفحه اینستاگرام ما</a>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">در خبرنامه توکا پت عضو شوید</h3>
                    <p class="mb-5">تخفیف‌های ویژه، محصولات جدید و نکات مراقبت از حیوانات را دریافت کنید</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="شماره همراه شما">
                        <button class="btn btn-dark" type="button">عضویت</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                // ایجاد افکت کلیک
                card.addEventListener('click', function(e) {
                    // جلوگیری از اجرا وقتی روی دکمه‌ها کلیک می‌شود
                    if (e.target.closest('.product-wishlist') || e.target.closest('.add-to-cart')) {
                        return;
                    }

                    // ایجاد افکت دایره‌ای
                    const effect = document.createElement('div');
                    effect.className = 'click-effect';
                    effect.style.width = '100px';
                    effect.style.height = '100px';
                    effect.style.left = e.offsetX - 50 + 'px';
                    effect.style.top = e.offsetY - 50 + 'px';
                    this.appendChild(effect);

                    // حذف افکت بعد از انیمیشن
                    setTimeout(() => {
                        effect.remove();
                    }, 600);

                    // گرفتن لینک محصول
                    const productLink = this.querySelector('a.product-link');
                    if (productLink) {
                        // هدایت به صفحه محصول بعد از تاخیر کوتاه
                        setTimeout(() => {
                            window.location.href = productLink.href;
                        }, 300);
                    }
                });
            });
        });
    </script>
@endsection
