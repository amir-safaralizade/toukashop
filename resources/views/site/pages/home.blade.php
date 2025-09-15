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


        .habitat-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.03) 0%, rgba(78, 205, 196, 0.03) 100%);
            border-radius: 30px;
            padding: 80px 0;
            margin: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .habitat-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(78, 205, 196, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .habitat-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255, 107, 107, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .habitat-header {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
            z-index: 2;
        }

        .section-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            margin-bottom: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 100px;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }

        .section-subtitle {
            font-size: 1.4rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .habitat-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .habitat-info {
            padding-left: 20px;
        }

        .habitat-features {
            list-style: none;
            padding: 0;
            margin: 0 0 40px 0;
        }

        .habitat-features li {
            margin-bottom: 20px;
            padding-right: 40px;
            position: relative;
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .habitat-features li::before {
            content: '✓';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
        }

        .habitat-image {
            position: relative;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transition: all 0.5s ease;
        }

        .habitat-image:hover {
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.2);
        }

        .habitat-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.8s ease;
        }

        .habitat-image:hover img {
            transform: scale(1.05);
        }

        .habitat-types {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 60px;
            position: relative;
            z-index: 2;
        }

        .habitat-type {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .habitat-type::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .habitat-type:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        }

        .type-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .habitat-type:hover .type-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .type-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .type-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .floating-animal {
            position: absolute;
            font-size: 3.5rem;
            opacity: 0.1;
            z-index: 1;
        }

        .floating-animal:nth-child(1) {
            top: 15%;
            left: 8%;
            animation: float 9s ease-in-out infinite;
        }

        .floating-animal:nth-child(2) {
            top: 65%;
            right: 7%;
            animation: float 8s ease-in-out infinite 1s;
        }

        .floating-animal:nth-child(3) {
            top: 35%;
            right: 12%;
            animation: float 10s ease-in-out infinite 0.5s;
        }

        .floating-animal:nth-child(4) {
            bottom: 10%;
            left: 15%;
            animation: float 7s ease-in-out infinite 1.5s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .habitat-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .habitat-types {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 40px auto 0;
            }

            .section-title {
                font-size: 2.3rem;
            }

            .habitat-image {
                height: 350px;
            }

            .floating-animal {
                display: none;
            }
        }





        .articles-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .articles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .article-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .article-card:hover .article-image img {
            transform: scale(1.1);
        }

        .article-badge {
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .article-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .article-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark-color);
            line-height: 1.4;
        }

        .article-excerpt {
            color: #666;
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.7;
            flex-grow: 1;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .article-date {
            color: #888;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .article-date i {
            margin-left: 5px;
        }

        .article-read-more {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .article-read-more:hover {
            color: var(--secondary-color);
        }

        .article-read-more i {
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        .article-read-more:hover i {
            transform: translateX(-5px);
        }

        .view-all-btn {
            text-align: center;
            margin-top: 50px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .articles-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }

            .section-title {
                font-size: 2.2rem;
            }
        }
    </style>
@endsection

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
                        <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}" alt="ظرف غذای حیوانات"
                            class="main-product">

                        <div class="floating-products">
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}"
                                    alt="ظرف غذای سگ">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg') }}"
                                    alt="ظرف غذای گربه">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1552053831-71594a27632d.jpeg') }}"
                                    alt="ظرف غذای پرنده">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/p1.jpeg') }}" alt="ظرف غذای همستر">
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


    <section class="articles-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge animate__animated animate__pulse animate__infinite">مطالب آموزشی</span>
                <h2 class="section-title animate__animated animate__fadeInDown">مقالات تخصصی توکا پت</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    جدیدترین مطالب آموزشی و تخصصی در زمینه نگهداری، تغذیه و سلامت حیوانات خانگی
                </p>
            </div>

            <div class="articles-container">
                @foreach ($data->posts as $post)
                    <div class="article-card animate__animated animate__fadeInLeft">
                        <div class="article-image">
                            <img src="{{ $post->firstMedia('main_image')?->full_url }}" alt="{{ $post->title }}">
                            <span class="article-badge">{{ $post->category->name }}</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">{{$post->title}}</h3>
                            <p class="article-excerpt">
                                چگونه بهترین رژیم غذایی را برای گربه خود انتخاب کنید؟ در این مقاله به بررسی نیازهای غذایی
                                گربه‌ها در سنین مختلف می‌پردازیم.
                            </p>
                            <div class="article-meta">
                                <span class="article-date"><i class="bi bi-calendar"></i>{{jdate($post->created_at)->format('Y-m-d')}}</span>
                                <a href="#" class="article-read-more">
                                    مطالعه مقاله <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="view-all-btn">
                <a href="#" class="btn btn-primary">مشاهده همه مقالات</a>
            </div>
        </div>
    </section>

    <section class="habitat-section">
        <div class="container">
            <!-- آیکون‌های شناور -->
            <i class="bi bi-house-door floating-animal"></i>
            <i class="bi bi-grid-3x3-gap floating-animal"></i>
            <i class="bi bi-box-seam floating-animal"></i>
            <i class="bi bi-shield-check floating-animal"></i>

            <div class="habitat-header">
                <span class="section-badge animate__animated animate__pulse animate__infinite">خانه امن برای حیوانات</span>
                <h2 class="section-title animate__animated animate__fadeInDown">لانه، قفس و باکس حیوانات</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    مکانی امن و راحت برای اعضای کوچک خانواده شما. همه محصولات با استاندارد و کیفیت و با مشاوره دامپزشکان
                    طراحی شده‌اند.
                </p>
            </div>

            <div class="habitat-content">
                <div class="habitat-info">
                    <h3 class="mb-4">خانه‌ای که شایسته حیوان شماست</h3>
                    <p class="mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #555;">
                        در توکا پت شاپ، ما اهمیت یک محیط زندگی امن، راحت و stimulating برای حیوانات خانگی را درک می‌کنیم.
                        هر محصول با دقت انتخاب شده تا نیازهای خاص هر حیوان را برآورده کند.
                    </p>

                    <ul class="habitat-features">
                        <li>ساخته شده از مواد باکیفیت و غیرسمی</li>
                        <li>طراحی ارگونومیک برای راحتی حیوان</li>
                        <li>قابلیت تمیزکاری آسان و نگهداری کم</li>
                        <li>امنیت بالا با قفل‌ها و درب‌های مطمئن</li>
                        <li>فضای کافی برای حرکت و فعالیت حیوان</li>
                        <li>مناسب برای استفاده در فضای داخلی و خارجی</li>
                    </ul>

                    <a class="btn btn-primary"
                        href="{{ route('products.categories', 'لانه-و-قفس-نگهداری-حیوانات') }}">مشاهده همه محصولات</a>
                </div>

                <div class="habitat-image animate__animated animate__fadeInRight">
                    <img src="{{ asset('site/images/image_tqvGenghp7vLzedr54DMgZgIemTRBn0TpE3S.webp') }}"
                        alt="لانه و قفس حیوانات">
                </div>
            </div>

            <div class="habitat-types">
                <div class="habitat-type animate__animated animate__fadeInUp">
                    <div class="type-icon">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h3 class="type-title">لانه‌های چوبی</h3>
                    <p class="type-description">
                        لانه‌های طبیعی و دنج که محیطی گرم و welcoming برای حیوانات کوچک فراهم می‌کنند.
                        مناسب برای همستر، خرگوش و حیوانات کوچک.
                    </p>
                </div>

                <div class="habitat-type animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="type-icon">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <h3 class="type-title">قفس‌های فلزی</h3>
                    <p class="type-description">
                        قفس‌های با دوام و ایمن با طراحی مدرن که فضای کافی برای پرواز و حرکت پرندگان و
                        دیگر حیوانات را فراهم می‌کنند.
                    </p>
                </div>

                <div class="habitat-type animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="type-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="type-title">بکس‌های حمل و نقل</h3>
                    <p class="type-description">
                        باکس‌های ایمن و راحت برای سفر و حمل و نقل حیوانات. طراحی شده برای
                        ایمنی و آرامش حیوان در هنگام جابجایی.
                    </p>
                </div>
            </div>
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

    <script>
        // افزودن انیمیشن هنگام اسکرول
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.habitat-type');

            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>


    <script>
        // افزودن انیمیشن هنگام اسکرول
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.article-card');

            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>
@endsection
