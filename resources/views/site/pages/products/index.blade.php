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
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--accent-color);
            color: var(--dark-color);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 10;
        }

        .product-img-container {
            height: 250px;
            overflow: hidden;
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

        .product-info {
            padding: 20px;
        }

        .product-category {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .product-title {
            font-weight: 900;
            font-size: 1.2rem;
            margin-bottom: 10px;
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
            height: 70px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .product-price {
            font-weight: 900;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .product-rating {
            color: var(--accent-color);
            font-size: 0.9rem;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .add-to-cart-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 700;
            flex: 1;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background: #e05a5a;
        }

        .wishlist-btn {
            background: #f8f9fa;
            color: #777;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover {
            color: var(--primary-color);
            background: #fff0f0;
        }

        .pagination {
            justify-content: center;
            margin: 40px 0;
        }

        .page-link {
            border: none;
            color: var(--dark-color);
            padding: 10px 18px;
            border-radius: 10px;
            margin: 0 5px;
            font-weight: 700;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: white;
        }

        .page-link:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
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

        /* Responsive */
        @media (max-width: 768px) {
            .category-tabs {
                gap: 10px;
            }

            .category-btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }

            .archive-header {
                padding: 60px 0;
            }

            body {
                padding-top: 70px;
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
            <h1 class="display-4 fw-bold mb-4">آرشیو محصولات</h1>
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
            <!-- Product -->
            @foreach ($products as $product)
                <div class="product-card" data-category="cats,food">
                    <div class="product-badge">پرفروش</div>
                    <div class="product-img-container">
                        <img src="{{ $product->firstMedia('main_image')->full_url }}" class="product-img" alt="غذای گربه" />
                    </div>
                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name }}</div>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p class="product-description">
                            {{ $product->name }}
                        </p>
                        <div class="product-meta">
                            <div class="product-price">{{ number_format($product->price) }} تومان</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                        </div>
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="add-to-cart-btn">
                                <i class="bi bi-cart-plus me-1"></i>افزودن
                            </a>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i>
                            </button>
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
