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
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
            padding: 0 15px;
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
        }

        .category-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .category-btn.active {
            background: var(--primary-color);
            color: white;
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
                gap: 10px;
            }

            .category-btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .category-btn {
                padding: 8px 12px;
                font-size: 0.8rem;
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
        <div class="category-tabs">
            <a class="btn category-btn active" href="{{ route('products.index') }}">
                <i class="bi bi-grid category-icon"></i>همه محصولات
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('products.categories', $category->slug) }}" class="btn category-btn" data-category="dogs">
                    <i class="bi bi-bag category-icon"></i>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container">
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card animate__animated animate__fadeInUp" data-category="cats,food">
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
