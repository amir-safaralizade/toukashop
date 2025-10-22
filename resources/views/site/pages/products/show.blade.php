@extends('layout.app')

@section('styles')
    <style>
        .breadcrumb {
            background-color: transparent;
            padding: 15px 0;
        }

        .breadcrumb-item {
            color: var(--dark-color);
            text-decoration: none;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .product-gallery {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .main-image {
            height: 500px;
            object-fit: cover;
            width: 100%;
        }

        .thumbnail-container {
            display: flex;
            margin-top: 15px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-left: 10px;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary-color);
        }

        .product-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .single-pro-product-title {
            font-weight: 900;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .product-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .rating {
            color: var(--accent-color);
            margin-left: 15px;
        }

        .review-count {
            color: #777;
            font-size: 0.9rem;
        }

        .price-container {
            margin: 25px 0;
        }

        .single-pro-current-price {
            font-weight: 900;
            font-size: 2rem;
            color: var(--primary-color);
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .discount-badge {
            background-color: var(--accent-color);
            color: var(--dark-color);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .product-description {
            margin: 30px 0;
            line-height: 1.8;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            background: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
        }

        .action-btns {
            display: flex;
            margin-top: 30px;
        }

        .s-p-add-to-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            margin-left: 15px;
            transition: all 0.3s ease;
        }

        .s-p-add-to-cart:hover {
            background-color: #e05a5a;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .wishlist-btn {
            background: none;
            border: 2px solid #ddd;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .product-meta-info {
            margin: 30px 0;
            padding: 20px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .meta-item {
            display: flex;
            margin-bottom: 15px;
        }

        .meta-item:last-child {
            margin-bottom: 0;
        }

        .meta-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(78, 205, 196, 0.1);
            color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .product-tabs {
            margin: 60px 0;
        }

        .nav-tabs {
            border-bottom: none;
            justify-content: center;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #777;
            font-weight: 700;
            padding: 15px 25px;
            position: relative;
            margin: 0 5px;
        }

        .nav-tabs .nav-link:after {
            display: none;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: none;
        }

        .nav-tabs .nav-link.active:before {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            bottom: 0;
            right: 25%;
            background-color: var(--primary-color);
            border-radius: 3px;
        }

        .tab-content {
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .related-products {
            margin: 60px 0;
        }

        .section-title {
            font-weight: 900;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
            margin-bottom: 50px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            bottom: -15px;
            right: 0;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 200px;
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
            background-color: var(--accent-color);
            color: var(--dark-color);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .price {
            font-weight: 900;
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-logo {
            font-weight: 900;
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }

        .footer-links h5 {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .footer-links h5:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 2px;
            bottom: -8px;
            right: 0;
            background: var(--primary-color);
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            padding-right: 5px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-image {
                height: 350px;
            }

            .action-btns {
                flex-direction: column;
            }

            .s-p-add-to-cart {
                margin-left: 0;
                margin-bottom: 15px;
                width: 100%;
            }

            .wishlist-btn {
                width: 100%;
                border-radius: 50px;
                height: auto;
                padding: 12px;
            }

            .tab-content {
                padding: 20px;
            }
        }
    </style>

    <style>
        /* استایل‌های جدید برای بخش‌های رنگ، سایز و سایر ویژگی‌ها */
        .size-options,
        .product-color-options,
        .product-attribute-options {
            margin: 20px 0;
        }

        .size-options h5,
        .product-color-options h5,
        .product-attribute-options h5 {
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .size-options-container,
        .color-options-container,
        .attribute-options-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .size-option {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .size-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .size-option.active {
            border-color: var(--primary-color);
            background-color: rgba(233, 69, 96, 0.1);
            color: var(--primary-color);
        }

        .color-option {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px white, 0 0 0 4px var(--primary-color);
        }

        .color-option.active::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        }

        .attribute-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            background-color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .attribute-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
            outline: none;
        }

        /* استایل برای نمایش انتخاب‌های رنگ و سایز */
        .selection-summary {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: rgba(78, 205, 196, 0.1);
            border-radius: 10px;
            border-right: 3px solid var(--secondary-color);
        }

        .selection-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .selection-item:last-child {
            margin-bottom: 0;
        }

        .selection-label {
            font-weight: 600;
            margin-left: 10px;
            min-width: 60px;
        }

        .selection-value {
            color: var(--dark-color);
        }

        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-left: 8px;
            vertical-align: middle;
            border: 1px solid #ddd;
        }
    </style>
@endsection

@section('seo')
    <x-seo::seo-meta-display :model="$product" />
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="container mt-128">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-primary"><a href="{{ route('page.home') }}">خانه</a></li>
                <li class="breadcrumb-item text-primary"><a href="{{ route('products.index') }}">محصولات</a></li>
                <li class="breadcrumb-item text-primary"><a
                        href="{{ route('products.categories', $product->category->slug) }}">{{ $product->category->name }}</a>
                </li>
                <li class="breadcrumb-item">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Product Section -->
    <section class="product-section">
        <div class="container">
            <div class="row">
                <!-- Product Gallery -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        @php
                            $mainImage = $product->firstMedia('main_image');
                            $galleryImages = $product->mediaGroup('gallery')->get();
                        @endphp
                        <img src="{{ $mainImage?->full_url }}" alt="{{ $mainImage?->alt ?? $product->name }}"
                            class="main-image" id="mainImage" onclick="zoomImage(this)" />
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

                <!-- Product Info -->
                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <h1 class="single-pro-product-title">{{ $product->name }}</h1>
                        <div class="product-meta">
                            <div class="rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            @if ($product->stock > 0)
                                <span class="badge bg-success ms-3">موجود در انبار</span>
                            @else
                                <span class="badge bg-danger ms-3">ناموجود</span>
                            @endif
                        </div>

                        <div class="price-container">
                            <span class="old-price">{{ number_format(ceil($product->price * 1.12)) }} تومان</span>
                            <span class="single-pro-current-price">{{ number_format($product->price) }} تومان</span>
                            <span class="discount-badge">۱۲٪ تخفیف</span>
                        </div>

                        <div class="product-description">
                            <p>محصول با کیفیت در توکاپت شاپ</p>
                        </div>

                        <!-- نمایش خلاصه انتخاب‌ها -->
                        <div class="selection-summary" id="selectionSummary" style="display: none;">
                            <div class="selection-item">
                                <span class="selection-label">سایز:</span>
                                <span class="selection-value" id="selectedSizeValue">-</span>
                            </div>
                            <div class="selection-item">
                                <span class="selection-label">رنگ:</span>
                                <span class="selection-value" id="selectedColorValue">-</span>
                                <span class="color-preview" id="selectedColorPreview"></span>
                            </div>
                            <div class="selection-item" id="selectedAttributeItem" style="display: none;">
                                <span class="selection-label" id="selectedAttributeLabel">ویژگی:</span>
                                <span class="selection-value" id="selectedAttributeValue">-</span>
                            </div>
                        </div>

                        @if ($product->attributeValues->where('attribute.name', 'size')->count())
                            <div class="size-options">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>سایز:</h5>
                                </div>
                                <div class="size-options-container">
                                    @foreach ($product->attributeValues->where('attribute.name', 'size') as $val)
                                        <input type="radio" id="size-{{ $val->id }}" name="product-size"
                                            value="{{ $val->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                                        <label for="size-{{ $val->id }}"
                                            class="size-option {{ $loop->first ? 'active' : '' }}">
                                            {{ $val->value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($product->attributeValues->where('attribute.name', 'color')->count())
                            <div class="product-color-options">
                                <h5>رنگ:</h5>
                                <div class="color-options-container">
                                    @foreach ($product->attributeValues->where('attribute.name', 'color') as $val)
                                        <input type="radio" id="color-{{ $val->id }}" name="product-color"
                                            value="{{ $val->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                                        <label for="color-{{ $val->id }}"
                                            class="color-option {{ $loop->first ? 'active' : '' }}"
                                            style="background-color: {{ $val->value }};"
                                            data-color-name="{{ $val->value }}" title="{{ $val->value }}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- سایر ویژگی‌های محصول (به صورت داینامیک) -->
                        @php
                            $otherAttributes = $product->attributeValues
                                ->filter(function ($value) {
                                    return !in_array($value->attribute->name, ['size', 'color']);
                                })
                                ->groupBy('attribute.name');
                        @endphp

                        @if ($otherAttributes->count())
                            @foreach ($otherAttributes as $attributeName => $values)
                                <div class="product-attribute-options">
                                    <h5>{{ $attributeName }}:</h5>
                                    <div class="attribute-options-container">
                                        <select class="attribute-select" name="attribute-{{ $attributeName }}"
                                            data-attribute-name="{{ $attributeName }}">
                                            @foreach ($values as $value)
                                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="quantity-selector mt-4">
                            <label for="quantity" class="me-3">تعداد:</label>
                            <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="number" value="1" min="1" class="quantity-input" id="quantity" />
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>

                        <div class="action-btns">
                            @if ($product->stock > 0)
                                <button class="s-p-add-to-cart pulse-animation" data-product-id="{{ $product->id }}">
                                    <i class="bi bi-cart-plus me-2"></i>افزودن به سبد خرید
                                </button>ّ
                            @else
                                <button class="btn btn-danger pulse-animation">
                                    <i class="bi bi-cart-plus me-2"></i> ناموجود (تماس بگیرید)
                                </button>
                            @endif
                        </div>

                        <!-- بقیه کد بدون تغییر -->
                    </div>
                </div>ّ
            </div>


            <!-- Product Tabs -->
            <div class="product-tabs mt-5">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab">توضیحات محصول</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs"
                            type="button" role="tab">مشخصات فنی</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabsContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <h4>{{ $product->name }}</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <h4>مشخصات فنی</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach ($product->technicalDetails as $t_item)
                                        <tr>
                                            <th>{{ $t_item->title }}</th>
                                            <td>{{ $t_item->value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container my-5 py-5">
                <div class="text-center mb-5">
                    <h2 class="section-title animate__animated animate__fadeInUp">محصولات مرتبط</h2>
                    <p class="lead">محصولاتی که ممکن است آنها را نیز بپسندید</p>
                </div>
                <div class="products-container">
                    @foreach ($relatedProducts as $r_product)
                        <div class="product-card animate__animated animate__fadeInUp">
                            <a href="{{ route('products.show', $r_product->slug) }}" class="product-link"></a>
                            <div class="product-badge">پرفروش</div>
                            <div class="product-img-container">
                                <img src="{{ asset($r_product->firstMedia('main_image')->full_url) }}"
                                    class="product-img" alt="{{ $r_product->name }}">
                            </div>
                            <div class="product-content">
                                <span class="product-category">{{ $r_product->category->name }}</span>
                                <h3 class="product-title">{{ $r_product->name }}</h3>
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
                                        <span class="current-price">{{ number_format($r_product->price) }} تومان</span>
                                        <span class="old-price">{{ number_format($r_product->price * 1.12) }} تومان</span>
                                    </div>
                                    <div class="product-actions">
                                        <a href="{{ route('products.show', $r_product->slug) }}" class="s-p-add-to-cart">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg text-dark">مشاهده همه
                        محصولات</a>
                </div>
            </section>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== GLOBAL VARIABLES ==========
            const variantStockData = @json($variantStockData);
            console.log('Variant Stock Data:', variantStockData);

            // ========== IMAGE GALLERY ==========
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

            // ========== QUANTITY SELECTOR ==========
            function increaseQuantity() {
                const qtyInput = document.getElementById('quantity');
                const maxQty = getMaxAvailableQuantity();
                let newVal = parseInt(qtyInput.value) + 1;
                qtyInput.value = newVal > maxQty ? maxQty : newVal;
            }

            function decreaseQuantity() {
                const qtyInput = document.getElementById('quantity');
                if (parseInt(qtyInput.value) > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                }
            }

            // ========== SELECTION SUMMARY ==========
            function updateSelectionSummary() {
                const sizeInput = document.querySelector('input[name="product-size"]:checked');
                const colorInput = document.querySelector('input[name="product-color"]:checked');
                const attributeSelects = document.querySelectorAll('.attribute-select');

                const summaryElement = document.getElementById('selectionSummary');
                let hasSelection = false;

                // Size
                if (sizeInput) {
                    const sizeLabel = document.querySelector(`label[for="size-${sizeInput.value}"]`);
                    if (sizeLabel) {
                        document.getElementById('selectedSizeValue').textContent = sizeLabel.textContent;
                        hasSelection = true;
                    }
                }

                // Color
                if (colorInput) {
                    const colorLabel = document.querySelector(`label[for="color-${colorInput.value}"]`);
                    if (colorLabel) {
                        const colorName = colorLabel.getAttribute('data-color-name');
                        document.getElementById('selectedColorValue').textContent = colorName;
                        document.getElementById('selectedColorPreview').style.backgroundColor = colorName;
                        hasSelection = true;
                    }
                }

                // Other attributes
                let attributeSelected = false;
                attributeSelects.forEach(select => {
                    if (select.value && select.selectedIndex > 0) {
                        const attributeName = select.getAttribute('data-attribute-name');
                        const selectedOption = select.options[select.selectedIndex];
                        document.getElementById('selectedAttributeLabel').textContent = attributeName + ':';
                        document.getElementById('selectedAttributeValue').textContent = selectedOption
                            .textContent;
                        document.getElementById('selectedAttributeItem').style.display = 'flex';
                        attributeSelected = true;
                        hasSelection = true;
                    }
                });

                if (!attributeSelected) {
                    document.getElementById('selectedAttributeItem').style.display = 'none';
                }

                summaryElement.style.display = hasSelection ? 'block' : 'none';
                updateAvailabilityStatus();
            }

            // ========== AVAILABILITY CHECK ==========
            function getCurrentAttributes() {
                const attributes = {};

                // Size
                const sizeInput = document.querySelector('input[name="product-size"]:checked');
                if (sizeInput) attributes.size = sizeInput.value;

                // Color
                const colorInput = document.querySelector('input[name="product-color"]:checked');
                if (colorInput) attributes.color = colorInput.value;

                // Other attributes
                document.querySelectorAll('.attribute-select').forEach(select => {
                    if (select.value && select.selectedIndex > 0) {
                        const attributeName = select.getAttribute('data-attribute-name');
                        attributes[attributeName] = select.value;
                    }
                });

                return attributes;
            }

            function findMatchingVariant(attributes) {
                return variantStockData.find(variant => {
                    let match = true;
                    Object.keys(attributes).forEach(attrKey => {
                        if (variant.attributes[attrKey] !== parseInt(attributes[attrKey])) {
                            match = false;
                        }
                    });
                    return match && variant.stock > 0;
                });
            }

            function getMaxAvailableQuantity() {
                const attributes = getCurrentAttributes();
                const variant = findMatchingVariant(attributes);
                return variant ? variant.stock : 0;
            }

            function updateAvailabilityStatus() {
                const attributes = getCurrentAttributes();
                const variant = findMatchingVariant(attributes);
                const addToCartBtn = document.querySelector('.s-p-add-to-cart');
                const quantityInput = document.getElementById('quantity');

                if (variant && variant.stock > 0) {
                    // Available
                    addToCartBtn.innerHTML = `<i class="bi bi-cart-plus me-2"></i>افزودن به سبد خرید`;
                    addToCartBtn.className = 's-p-add-to-cart pulse-animation btn-success';
                    addToCartBtn.disabled = false;
                    quantityInput.max = variant.stock;

                    // Show stock info
                    const stockBadge = document.querySelector('.stock-badge');
                    if (stockBadge) {
                        stockBadge.textContent = `موجودی: ${variant.stock}`;
                        stockBadge.className = 'badge bg-success stock-badge';
                    }
                } else {
                    // Unavailable
                    let btnText = 'ترکیب ناموجود';
                    if (Object.keys(attributes).length === 0 && variantStockData.length === 0) {
                        btnText = 'ناموجود';
                    }

                    addToCartBtn.innerHTML = `<i class="bi bi-cart-x me-2"></i>${btnText}`;
                    addToCartBtn.className = 's-p-add-to-cart btn-danger';
                    addToCartBtn.disabled = true;
                    quantityInput.max = 0;

                    // Show stock info
                    const stockBadge = document.querySelector('.stock-badge');
                    if (stockBadge) {
                        stockBadge.textContent = 'ناموجود';
                        stockBadge.className = 'badge bg-danger stock-badge';
                    }
                }
            }

            // ========== ADD TO CART ==========
            document.addEventListener('click', function(e) {
                if (e.target.closest('.s-p-add-to-cart') && !e.target.closest('.s-p-add-to-cart')
                    .disabled) {
                    e.preventDefault();
                    const addToCartBtn = e.target.closest('.s-p-add-to-cart');
                    handleAddToCart(addToCartBtn);
                }
            });

            function handleAddToCart(addToCartBtn) {
                const productId = addToCartBtn.getAttribute('data-product-id');
                const quantity = parseInt(document.getElementById('quantity').value);
                const attributes = getCurrentAttributes();

                // ========== LOADING ==========
                const originalText = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner me-2"></i>در حال افزودن...';
                addToCartBtn.disabled = true;

                // ========== AJAX ==========
                fetch('{{ route('cart.addToCartAjax') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: parseInt(productId),
                            quantity: quantity,
                            size: attributes.size || null,
                            color: attributes.color || null,
                            attributes: Object.keys(attributes).filter(key => !['size', 'color']
                                    .includes(key))
                                .reduce((obj, key) => {
                                    obj[key] = attributes[key];
                                    return obj;
                                }, {})
                        })
                    })
                    .then(response => {
                        if (response.status === 422) {
                            return response.json().then(data => {
                                throw {
                                    status: 422,
                                    data
                                };
                            });
                        }
                        if (!response.ok) {
                            throw {
                                status: response.status,
                                message: `خطای سرور: ${response.status}`
                            };
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'موفق!',
                                text: data.message,
                                showCancelButton: true,
                                confirmButtonText: 'ادامه خرید',
                                cancelButtonText: 'مشاهده سبد',
                                confirmButtonColor: '#28a745',
                                cancelButtonColor: '#007bff'
                            }).then((result) => {
                                if (result.isDismissed || result.dismiss === 'cancel') {
                                    window.location.href = '{{ route('cart.mycart') }}';
                                }
                            });
                            updateCartCount(data.cart_count);
                            playSuccessSound();
                        }
                    })
                    .catch(error => {
                        console.error('Add to cart error:', error);

                        let title = 'خطا',
                            errorMessage = 'خطای نامشخص',
                            icon = 'error';

                        if (error.status === 422 && error.data) {
                            switch (error.data.type) {
                                case 'combination_unavailable':
                                case 'variant_not_found':
                                    title = 'ترکیب ناموجود';
                                    errorMessage = 'ترکیب انتخابی موجود نمی‌باشد.';
                                    icon = 'warning';
                                    highlightInvalidSelection();
                                    break;
                                case 'insufficient_stock':
                                    title = 'موجودی کم';
                                    errorMessage = `تعداد موجود: ${error.data.available_stock}`;
                                    icon = 'warning';
                                    break;
                                case 'insufficient_stock_with_cart':
                                    title = 'موجودی کم';
                                    errorMessage =
                                        `موجودی: ${error.data.available_stock} - در سبد: ${error.data.current_in_cart}`;
                                    icon = 'warning';
                                    break;
                                default:
                                    errorMessage = error.data.message || 'خطا در افزودن';
                            }
                        } else if (error.status >= 500) {
                            title = 'خطای سرور';
                            errorMessage = 'لطفاً دوباره تلاش کنید.';
                        } else {
                            errorMessage = 'مشکل در اتصال به سرور';
                        }

                        Swal.fire({
                            icon: icon,
                            title: title,
                            html: errorMessage,
                            confirmButtonText: 'متوجه شدم',
                            confirmButtonColor: '#dc3545'
                        });
                    })
                    .finally(() => {
                        updateAvailabilityStatus();
                    });
            }

            // ========== HIGHLIGHT INVALID ==========
            function highlightInvalidSelection() {
                ['size', 'color'].forEach(type => {
                    const input = document.querySelector(`input[name="product-${type}"]:checked`);
                    if (input) {
                        const label = document.querySelector(`label[for="${type}-${input.value}"]`);
                        if (label) {
                            label.style.borderColor = '#dc3545';
                            label.style.boxShadow = '0 0 0 2px #dc3545';
                            setTimeout(() => {
                                label.style.borderColor = '';
                                label.style.boxShadow = '';
                            }, 3000);
                        }
                    }
                });
            }

            // ========== EVENT LISTENERS ==========
            // Size
            document.querySelectorAll('input[name="product-size"]').forEach(input => {
                input.addEventListener('change', () => {
                    document.querySelectorAll('.size-option').forEach(l => l.classList.remove(
                        'active'));
                    const label = document.querySelector(`label[for="size-${input.value}"]`);
                    if (label) label.classList.add('active');
                    updateSelectionSummary();
                });
            });

            // Color
            document.querySelectorAll('input[name="product-color"]').forEach(input => {
                input.addEventListener('change', () => {
                    document.querySelectorAll('.color-option').forEach(l => l.classList.remove(
                        'active'));
                    const label = document.querySelector(`label[for="color-${input.value}"]`);
                    if (label) label.classList.add('active');
                    updateSelectionSummary();
                });
            });

            // Attributes
            document.querySelectorAll('.attribute-select').forEach(select => {
                select.addEventListener('change', updateSelectionSummary);
            });

            // Quantity buttons
            document.addEventListener('click', e => {
                if (e.target.classList.contains('quantity-btn')) {
                    e.preventDefault();
                    if (e.target.textContent === '+') increaseQuantity();
                    else decreaseQuantity();
                }
            });

            // Initial setup
            updateSelectionSummary();
            updateAvailabilityStatus();

            // ========== UTILITIES ==========
            function updateCartCount(count) {
                document.querySelectorAll('#touka_cart_items_count, .cart-count, .cart-badge')
                    .forEach(badge => {
                        badge.textContent = count;
                        badge.style.display = count > 0 ? 'inline' : 'none';
                    });
            }

            function playSuccessSound() {
                try {
                    new Audio('/sounds/success.mp3').play().catch(() => {});
                } catch (e) {}
            }

            // ========== STYLES ==========
            const style = document.createElement('style');
            style.textContent = `
        .spinner { animation: spin 1s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .stock-badge { margin-left: 10px; }
        .btn-danger:disabled { opacity: 0.6; cursor: not-allowed; }
    `;
            document.head.appendChild(style);

            // Zoom
            document.getElementById('mainImage').addEventListener('click', function() {
                zoomImage(this);
            });
        });
    </script>
@endsection
