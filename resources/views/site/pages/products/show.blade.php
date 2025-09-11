@extends('layout.app')

@section('styles')
    <style>
        /* محصولات - استایل‌های پایه */
        .product-main {
            padding: 4rem 0;
            background-color: var(--cream);
        }

        /* گالری محصول */
        .product-gallery {
            position: relative;
            background-color: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeInUp 0.6s ease-out;
        }

        .main-image-container {
            width: 100%;
            max-height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            background-color: var(--cream);
        }

        .main-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .main-image:hover {
            transform: scale(1.03);
        }

        .thumbnail-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 100%;
            overflow-x: auto;
            padding: 10px 0;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background-color: var(--cream);
            padding: 5px;
        }

        .thumbnail:hover {
            border-color: var(--pink);
            transform: translateY(-5px);
        }

        .thumbnail.active {
            border-color: var(--purple);
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.3);
        }

        /* افکت زوم روی تصویر اصلی */
        .zoomed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: zoom-out;
        }

        .zoomed img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        /* استایل بخش اطلاعات محصول */
        .product-info {
            background-color: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            animation: fadeInUp 0.6s ease-out;
            animation-delay: 0.2s;
        }

        .product-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .product-subtitle {
            font-size: 1.1rem;
            color: var(--purple);
            margin-bottom: 1.5rem;
        }

        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--purple);
            margin-bottom: 2rem;
        }

        .product-oldprice {
            text-decoration: line-through;
            color: var(--pink);
            font-size: 1.2rem;
            margin-left: 0.8rem;
        }

        /* استایل انتخاب رنگ */
        .product-color-options {
            margin-bottom: 2rem;
        }

        .product-color-options h5 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .color-options-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
        }

        .color-option {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        input[name="product-color"]:checked+.color-option {
            border-color: var(--text-dark);
            box-shadow: 0 0 0 2px var(--white), 0 0 0 4px var(--text-dark);
        }

        .color-option::after {
            content: attr(title);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.7rem;
            background-color: var(--text-dark);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .color-option:hover::after {
            opacity: 1;
        }

        /* استایل انتخاب سایز */
        .size-options {
            margin-bottom: 2rem;
        }

        .size-options h5 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .size-options-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
        }

        .size-option {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 10px;
            cursor: pointer;
            background-color: var(--light-pink);
            color: var(--text-dark);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .size-option:hover {
            background-color: var(--pink);
            color: white;
        }

        input[name="product-size"]:checked+.size-option {
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: white;
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.3);
        }

        .size-option.unavailable {
            background-color: #f5f5f5;
            color: #999;
            text-decoration: line-through;
            cursor: not-allowed;
        }

        input[name="product-size"]:disabled+.size-option {
            pointer-events: none;
        }

        /* استایل انتخاب تعداد */
        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .quantity-selector h5 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 0;
            margin-left: 1rem;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background-color: var(--light-pink);
            color: var(--text-dark);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background-color: var(--pink);
            color: white;
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid var(--light-pink);
            border-radius: 10px;
            margin: 0 0.5rem;
            font-weight: 600;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--purple);
        }

        /* استایل دکمه‌های اصلی */
        .add-to-cart {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
            margin-bottom: 1rem;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(179, 153, 212, 0.4);
        }

        .add-to-cart::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .add-to-cart:hover::after {
            left: 100%;
        }

        .add-to-cart i {
            margin-left: 0.8rem;
            font-size: 1.2rem;
        }

        .wishlist-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            color: var(--text-dark);
            border: 2px solid var(--light-pink);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .wishlist-btn:hover {
            background-color: var(--light-pink);
            border-color: var(--pink);
            color: var(--pink);
        }

        .wishlist-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 158, 183, 0.1);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover::after {
            left: 100%;
        }

        .wishlist-btn i {
            margin-left: 0.8rem;
            font-size: 1.2rem;
        }

        /* استایل نشان‌های اعتماد */
        .trust-badges {
            border-top: 1px solid rgba(179, 153, 212, 0.2);
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .badge-item {
            background-color: var(--light-pink);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .badge-item:hover {
            background-color: var(--pink);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 158, 183, 0.3);
        }

        .badge-item i {
            margin-left: 0.5rem;
        }

        /* استایل بخش "چرا از ما خرید کنید" */
        .why-us {
            margin-top: 3rem;
            padding: 2rem 0;
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
        }

        .why-us h4 {
            font-family: 'Dancing Script', cursive;
            color: var(--purple);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .feature-card {
            background-color: var(--cream);
            border-radius: 15px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
            padding: 1.5rem;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(179, 153, 212, 0.2);
        }

        .feature-card i {
            font-size: 2rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--pink), var(--purple));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .feature-card h6 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .feature-card p {
            font-size: 0.9rem;
            color: var(--purple);
            margin-bottom: 0;
        }

        /* استایل تب‌های محصول */
        .product-details {
            margin-top: 4rem;
        }

        .details-tabs {
            display: flex;
            border-bottom: 1px solid rgba(179, 153, 212, 0.2);
            margin-bottom: 2rem;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 1rem 2rem;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            font-family: inherit;
            font-size: inherit;
        }

        .tab-btn:hover {
            color: var(--purple);
        }

        .tab-btn.active {
            color: var(--pink);
        }

        .tab-btn.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--pink), var(--purple));
        }

        .tab-content {
            display: none;
            padding: 1.5rem;
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            animation: fadeIn 0.3s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* استایل محصولات مرتبط */
        .related-products {
            padding: 4rem 0;
            background-color: var(--white);
        }

        .related-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .related-card {
            background-color: var(--cream);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .related-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(179, 153, 212, 0.2);
        }

        .related-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-card:hover .related-img {
            transform: scale(1.05);
        }

        .related-info {
            padding: 1.5rem;
            text-align: center;
        }

        .related-name {
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .related-price {
            font-weight: 700;
            color: var(--purple);
            font-size: 1.1rem;
        }

        /* استایل رسپانسیو */
        @media (max-width: 992px) {
            .product-title {
                font-size: 2rem;
            }

            .main-image-container {
                max-height: 400px;
            }
        }

        @media (max-width: 768px) {

            .product-gallery,
            .product-info {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.8rem;
            }

            .thumbnail {
                width: 60px;
                height: 60px;
            }

            .trust-badges {
                justify-content: center;
            }

            .feature-card {
                padding: 1rem;
            }

            .details-tabs {
                flex-wrap: wrap;
            }

            .tab-btn {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .product-main {
                padding: 2rem 0;
            }

            .main-image-container {
                max-height: 350px;
            }

            .thumbnail {
                width: 50px;
                height: 50px;
            }

            .size-option {
                width: 40px;
                height: 40px;
            }

            .why-us .col-6 {
                padding: 0 5px;
            }

            .related-title {
                font-size: 2rem;
            }
        }


        .size-guide-link {
            display: inline-flex;
            align-items: center;
            color: var(--purple);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            background-color: rgba(179, 153, 212, 0.1);
        }

        .size-guide-link:hover {
            background-color: rgba(179, 153, 212, 0.2);
            text-decoration: underline;
        }

        .size-guide-link i {
            margin-left: 0.3rem;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('seo')
    <x-seo::seo-meta-display :model="$product" />
@endsection

@section('content')
    <main class="product-main">
        <div class="container">
            <div class="row">
                <!-- تصاویر محصول -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        @php
                            $mainImage = $product->firstMedia('main_image');
                            $galleryImages = $product->mediaGroup('gallery')->get();
                        @endphp

                        <div class="main-image-container">
                            <img src="{{ $mainImage?->full_url }}" alt="{{ $mainImage?->alt ?? $product->name }}"
                                class="main-image" id="mainImage" onclick="zoomImage(this)" />
                        </div>

                        <div class="thumbnail-container mt-3">
                            @if ($mainImage)
                                <img src="{{ $mainImage->full_url }}" alt="{{ $mainImage->alt ?? $product->name }}"
                                    class="thumbnail active" onclick="changeImage(this, '{{ $mainImage->full_url }}')" />
                            @endif

                            @foreach ($galleryImages as $image)
                                <img src="{{ $image->full_url }}" alt="{{ $image->alt ?? $product->name }}"
                                    class="thumbnail" onclick="changeImage(this, '{{ $image->full_url }}')" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- اطلاعات محصول -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <p class="product-subtitle">
                            {{ $product->short_description ?? 'محصول با کیفیت از برند ونل' }}
                        </p>

                        <div class="product-price">
                            <span class="product-oldprice">{{ number_format(ceil($product->price * 1.12)) }} تومان</span>
                            {{ number_format($product->price) }} تومان
                        </div>

                        <div class="quantity-selector mt-4">
                            <h5 class="mb-0">تعداد:</h5>
                            <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="number" value="1" min="1" class="quantity-input" id="quantity" />
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>

                        {{-- انتخاب سایز --}}
                        @if ($product->attributeValues->where('attribute.name', 'size')->count())
                            <div class="size-options">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>سایز:</h5>
                                    <a href="{{ route('page.size-selection-guide') }}" class="size-guide-link">
                                        <i class="bi bi-rulers"></i> راهنمای انتخاب سایز
                                    </a>
                                </div>
                                <div class="size-options-container">
                                    @foreach ($product->attributeValues->where('attribute.name', 'size') as $val)
                                        <input type="radio" id="size-{{ $val->id }}" name="product-size"
                                            value="{{ $val->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                                        <label for="size-{{ $val->id }}" class="size-option">
                                            {{ $val->value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- انتخاب رنگ --}}
                        @if ($product->attributeValues->where('attribute.name', 'color')->count())
                            <div class="product-color-options">
                                <h5>رنگ:</h5>
                                <div class="color-options-container">
                                    @foreach ($product->attributeValues->where('attribute.name', 'color') as $val)
                                        <input type="radio" id="color-{{ $val->id }}" name="product-color"
                                            value="{{ $val->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                                        <label for="color-{{ $val->id }}" class="color-option"
                                            style="background-color: {{ $val->value }};" title="{{ $val->value }}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        <button class="add-to-cart mt-3">
                            <i class="bi bi-cart-fill"></i> افزودن به سبد خرید
                        </button>

                        <button class="wishlist-btn mt-2">
                            <i class="bi bi-heart"></i> افزودن به لیست علاقه‌مندی‌ها
                        </button>

                        <div class="trust-badges">
                            <div class="badge-item">
                                <i class="bi bi-shield-check"></i>
                                <span>گارانتی اصالت کالا</span>
                            </div>
                            <div class="badge-item">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>بازگشت ۷ روزه</span>
                            </div>
                            <div class="badge-item">
                                <i class="bi bi-truck"></i>
                                <span>ارسال سریع</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- بخش "چرا از ما خرید کنید" -->
            <div class="why-us">
                <h4>چرا از ونل خرید کنید؟</h4>
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="feature-card">
                            <i class="bi bi-star-fill"></i>
                            <h6>کیفیت بالا</h6>
                            <p>محصولات با کیفیت ممتاز</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="feature-card">
                            <i class="bi bi-truck"></i>
                            <h6>ارسال سریع</h6>
                            <p>ارسال در کمترین زمان</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="feature-card">
                            <i class="bi bi-shield-check"></i>
                            <h6>پشتیبانی عالی</h6>
                            <p>پشتیبانی ۲۴ ساعته</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="feature-card">
                            <i class="bi bi-credit-card"></i>
                            <h6>پرداخت امن</h6>
                            <p>پرداخت آنلاین ایمن</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تب‌های محصول -->
            <div class="product-details">
                <div class="details-tabs">
                    <button type="button" class="tab-btn active" data-tab="description">
                        توضیحات محصول
                    </button>
                    <button type="button" class="tab-btn" data-tab="specs">
                        مشخصات فنی
                    </button>
                    <button type="button" class="tab-btn" data-tab="reviews">
                        نظرات کاربران
                    </button>
                </div>

                <div id="description" class="tab-content active">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                </div>

                <div id="specs" class="tab-content">
                    <!-- محتوای مشخصات فنی -->
                </div>

                <div id="reviews" class="tab-content">
                    <!-- محتوای نظرات کاربران -->
                </div>
            </div>
        </div>
    </main>

    <!-- محصولات مرتبط -->
    @if (sizeof($relatedProducts) > 0)
        <section class="related-products">
            <div class="container">
                <h3 class="related-title">محصولات مشابه</h3>
                <div class="row">
                    @foreach ($relatedProducts as $r_product)
                        <div class="col-md-3 col-6">
                            <div class="related-card">
                                <img src="{{ $r_product->firstMedia('main_image')->full_url }}" class="related-img"
                                    alt="{{ $r_product->name }}" />
                                <div class="related-info">
                                    <h4 class="related-name">{{ $r_product->name }}</h4>
                                    <p class="related-price">{{ number_format($r_product->price) . ' تومان' }}</p>
                                </div>
                                <a href="{{ route('products.show', $r_product->slug) }}"
                                    class="btn-vanell d-block text-center">
                                    <i class="bi bi-cart-fill me-1"></i> افزودن
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')
    <script>
        // اسکریپت‌های گالری تصاویر
        function changeImage(thumb, newSrc) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = newSrc;

            document.querySelectorAll('.thumbnail').forEach(el => el.classList.remove('active'));
            thumb.classList.add('active');

            mainImage.style.transform = 'scale(1)';
        }

        function zoomImage(img) {
            if (img.classList.contains('zoomed')) {
                img.classList.remove('zoomed');
                document.body.style.overflow = 'auto';
            } else {
                img.classList.add('zoomed');
                document.body.style.overflow = 'hidden';
            }
        }

        // بستن زوم با کلیک خارج از تصویر
        document.addEventListener('click', function(e) {
            const zoomedImg = document.querySelector('.main-image.zoomed');
            if (zoomedImg && !zoomedImg.contains(e.target)) {
                zoomImage(zoomedImg);
            }
        });

        // مدیریت تعداد محصول
        function increaseQuantity() {
            const qtyInput = document.getElementById('quantity');
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }

        function decreaseQuantity() {
            const qtyInput = document.getElementById('quantity');
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        }

        // مدیریت انتخاب رنگ و سایز
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="product-color"]').forEach(input => {
                input.addEventListener('change', function() {
                    document.querySelectorAll('.color-option').forEach(l => l.classList.remove(
                        'active'));
                    const label = document.querySelector('label[for="color-' + this.value + '"]');
                    label.classList.add('active');
                });
            });

            document.querySelectorAll('input[name="product-size"]').forEach(input => {
                input.addEventListener('change', function() {
                    document.querySelectorAll('.size-option').forEach(l => l.classList.remove(
                        'active'));
                    const label = document.querySelector('label[for="size-' + this.value + '"]');
                    label.classList.add('active');
                });
            });

            // مدیریت تب‌ها
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');

                    // غیرفعال کردن تمام تب‌ها
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });

                    // غیرفعال کردن تمام دکمه‌ها
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                    });

                    // فعال کردن تب و دکمه مربوطه
                    document.getElementById(tabId).classList.add('active');
                    this.classList.add('active');
                });
            });

            // افزودن به سبد خرید با Ajax
            const addToCartBtn = document.querySelector('.add-to-cart');

            addToCartBtn.addEventListener('click', function() {
                const productId = {{ $product->id }};
                const quantity = document.getElementById('quantity').value;
                const colorInput = document.querySelector('input[name="product-color"]:checked');
                const sizeInput = document.querySelector('input[name="product-size"]:checked');
                const color = colorInput ? colorInput.value : null;
                const size = sizeInput ? sizeInput.value : null;

                // نمایش لودر
                addToCartBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> در حال پردازش...';
                addToCartBtn.disabled = true;

                // ارسال درخواست Ajax
                fetch('{{ route('cart.addToCartAjax') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity,
                            color: color,
                            size: size
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'موفقیت آمیز',
                                text: 'محصول با موفقیت به سبد خرید اضافه شد',
                                confirmButtonText: 'باشه',
                                confirmButtonColor: '#8e44ad'
                            });

                            // به‌روزرسانی تعداد آیتم‌های سبد خرید در هدر
                            if (data.cart_count) {
                                const cartCount = document.querySelector('.cart-count');
                                if (cartCount) {
                                    cartCount.textContent = data.cart_count;
                                }
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا',
                                text: data.message || 'خطایی در افزودن به سبد خرید رخ داد',
                                confirmButtonText: 'باشه',
                                confirmButtonColor: '#8e44ad'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: 'خطایی در ارتباط با سرور رخ داد',
                            confirmButtonText: 'باشه',
                            confirmButtonColor: '#8e44ad'
                        });
                    })
                    .finally(() => {
                        addToCartBtn.innerHTML = '<i class="bi bi-cart-fill"></i> افزودن به سبد خرید';
                        addToCartBtn.disabled = false;
                    });
            });
        });
    </script>
@endsection
