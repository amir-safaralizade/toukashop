@extends('layout.app')

@section('styles')
    <style>
        :root {
            --pink: #ff9eb7;
            --light-pink: #ffd6de;
            --dark-pink: #ff7ba3;
            --purple: #b399d4;
            --light-purple: #d9c5f4;
            --cream: #fff4f6;
            --white: #ffffff;
            --text-dark: #5a3d5c;
            --text-light: #ffffff;
            --black: #1a1a1a;
        }

        .products-archive {
            padding: 2rem 0;
            background-color: var(--cream);
        }

        .archive-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .archive-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.2rem;
            color: var(--text-dark);
            margin-bottom: 0.8rem;
        }

        .archive-description {
            color: var(--text-dark);
            opacity: 0.8;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        /* استایل‌های جدید برای دسته‌بندی‌ها */
        .categories-filter-container {
            width: 100%;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .categories-filter {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .category-btn {
            background-color: var(--white);
            color: var(--text-dark);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--light-purple);
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 0.5rem;
            font-size: 0.85rem;
            text-align: center;
            width: 100%;
            display: block;
        }

        .category-btn:hover,
        .category-btn.active {
            background: linear-gradient(to right, var(--pink), var(--purple));
            color: var(--white);
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.3);
        }

        .category-btn:active {
            transform: scale(0.98);
        }

        /* استایل‌های محصولات */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .product-card {
            background-color: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(179, 153, 212, 0.2);
        }

        .product-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--purple);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-image-container {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1.2rem;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 1rem;
            height: 3.6em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-top: 0.8rem;
        }

        .current-price {
            font-weight: 700;
            color: var(--purple);
            font-size: 1.1rem;
        }

        .old-price {
            text-decoration: line-through;
            color: var(--text-dark);
            opacity: 0.6;
            font-size: 0.8rem;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.2rem;
            padding-top: 1.2rem;
            border-top: 1px solid rgba(179, 153, 212, 0.2);
        }

        .add-to-wishlist {
            background-color: transparent;
            border: none;
            color: var(--light-pink);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.3rem;
        }

        .add-to-wishlist:hover,
        .add-to-wishlist.active {
            color: var(--dark-pink);
            transform: scale(1.1);
        }

        .add-to-cart {
            background: linear-gradient(to right, var(--pink), var(--purple));
            color: var(--white);
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .add-to-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(179, 153, 212, 0.3);
        }

        /* استایل‌های دسکتاپ */
        @media (min-width: 768px) {
            .products-archive {
                padding: 3rem 0;
            }

            .archive-header {
                margin-bottom: 3rem;
                padding: 0;
            }

            .archive-title {
                font-size: 2.8rem;
                margin-bottom: 1rem;
            }

            .archive-description {
                font-size: 1rem;
            }

            .categories-filter-container {
                margin-bottom: 2.5rem;
                padding: 0;
            }

            .categories-filter {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                grid-template-columns: none;
                gap: 1rem;
            }

            .category-btn {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
                border-radius: 50px;
                width: auto;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 2rem;
                padding: 0;
            }

            .product-image-container {
                height: 220px;
            }

            .product-badge {
                top: 15px;
                right: 15px;
                padding: 0.3rem 1rem;
                font-size: 0.8rem;
            }

            .product-content {
                padding: 1.5rem;
            }

            .product-name {
                font-size: 1.1rem;
            }

            .add-to-cart {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        @media (min-width: 992px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }
    </style>
@endsection

@section('content')
    <section class="products-archive">
        <div class="container">
            <div class="archive-header">
                <h1 class="archive-title">
                    @if (empty(request('category')))
                        محصولات ما
                    @else
                        @php
                            $category = $categories->first(fn($item) => $item->id == request('category'));
                        @endphp
                        {{ $category->name ?? 'دسته‌بندی پیدا نشد' }}
                    @endif
                </h1>
                <h2 class="archive-description">کفش هایی با کیفیت , مقرون به صرفه و جذاب برای شما در فروشگاه ونل</h2>
            </div>

            <div class="categories-filter-container">
                <div class="categories-filter">
                    <a href="{{ route('products.index') }}"
                        class="category-btn @if (empty(Request::get('category'))) active @endif">همه محصولات</a>
                    @foreach ($categories as $item)
                        <a href="{{ route('products.categories', $item->slug) }}"
                            class="category-btn">{{ $item->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="products-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->slug) }}" class="product-link">
                            @if ($product->discount > 0)
                                <span class="product-badge">{{ $product->discount }}٪ تخفیف</span>
                            @endif
                            <div class="product-image-container">
                                <img src="{{ $product->firstMedia('main_image')?->full_url }}" alt="{{ $product->name }}"
                                    class="product-image" loading="lazy">
                            </div>
                            <div class="product-content">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="product-price">
                                    <span class="current-price">
                                        {{ number_format($product->price) . ' تومان' }}
                                    </span>
                                    @if ($product->old_price > $product->price)
                                        <span class="old-price">
                                            {{ number_format($product->old_price) . ' تومان' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="product-actions">
                            <button class="add-to-wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="add-to-cart">افزودن به سبد</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
