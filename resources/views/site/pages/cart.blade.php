@extends('layout.app')

@section('styles')
    <style>
        .cart-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .cart-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 15px 15px 0 0;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background-color: #f9f9f9;
        }

        .cart-item-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            margin-left: 20px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .cart-item-desc {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .cart-item-price {
            font-weight: 900;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #ddd;
            background: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .quantity-input {
            width: 50px;
            height: 35px;
            text-align: center;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
            font-size: 1rem;
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--danger);
            font-size: 1.2rem;
            margin-right: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            color: #bd2130;
            transform: scale(1.1);
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .cart-summary {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 25px;
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-weight: 900;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: 900;
            font-size: 1.3rem;
            margin: 25px 0;
            padding-top: 15px;
            border-top: 2px solid #eee;
        }

        .discount-section {
            margin: 25px 0;
        }

        .discount-input {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .apply-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .apply-btn:hover {
            background: #3bbbb5;
            transform: translateY(-2px);
        }

        .checkout-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .pet-icon {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.1;
            z-index: -1;
        }

        /* Form Styling */
        .checkout-form {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-title {
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .section-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--purple);
            margin-bottom: 20px;
        }

        .form-control,
        .form-select {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(255, 107, 107, 0.2);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .shipping-options,
        .payment-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .shipping-option,
        .payment-option {
            flex: 1 1 calc(50% - 15px);
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #f8f9fa;
        }

        .shipping-option:hover,
        .payment-option:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .shipping-radio,
        .payment-radio {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .shipping-radio:checked+.shipping-label::before,
        .payment-radio:checked+.payment-label::before {
            content: '';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 20px;
            height: 20px;
            background: var(--success);
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .shipping-label,
        .payment-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .shipping-icon,
        .payment-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 15px;
        }

        .shipping-title,
        .payment-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .shipping-desc,
        .payment-desc {
            font-size: 0.85rem;
            color: #777;
        }

        .payment-option.disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .payment-option.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        .card-transfer-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        .bank-card {
            background: linear-gradient(135deg, #4a4a4a, #2c2c2c);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .bank-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .bank-name {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .card-type {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .bank-logo {
            width: 50px;
            height: auto;
        }

        .card-number {
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .card-holder {
            font-size: 0.95rem;
        }

        .card-holder-label {
            font-size: 0.8rem;
            opacity: 0.7;
            display: block;
        }

        .instruction-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--purple);
            margin-bottom: 15px;
        }

        .instruction-steps {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .step-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .step-item i {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-right: 10px;
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
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item-img {
                margin-left: 0;
                margin-bottom: 15px;
                width: 100%;
                height: auto;
                max-height: 200px;
            }

            .cart-item-actions {
                width: 100%;
                justify-content: space-between;
                margin-top: 15px;
            }

            .shipping-option,
            .payment-option {
                flex: 1 1 100%;
            }

            .cart-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('content')


    <div class="mt-128"></div>
    <!-- Floating pet icons -->
    <i class="bi bi-egg-fried pet-icon floating" style="top: 15%; left: 5%; animation-delay: 0.2s"></i>
    <i class="bi bi-bone pet-icon floating" style="top: 80%; right: 10%; animation-delay: 0.5s"></i>
    <i class="bi bi-balloon-heart pet-icon floating" style="top: 40%; right: 5%; animation-delay: 0.7s"></i>
    <i class="bi bi-gem pet-icon floating" style="bottom: 10%; left: 15%; animation-delay: 0.3s"></i>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-container">
                    <div class="cart-header">
                        <h2 class="mb-0"><i class="bi bi-cart3 me-2"></i>سبد خرید شما</h2>
                    </div>

                    @if ($order->items->count() > 0)
                        @foreach ($order->items as $index => $item)
                            @php
                                $image = $item->product->firstMedia('main_image');
                            @endphp
                            <div class="cart-item">
                                <img src="{{ $image?->full_url }}" class="cart-item-img"
                                    alt="{{ $image?->alt ?? $item->product->name }}" />
                                <div class="cart-item-info">
                                    <h3 class="cart-item-title">{{ $item->product->name }}</h3>
                                    <p class="cart-item-desc">{{ $item->product->short_description ?? 'محصول با کیفیت' }}
                                    </p>
                                    <div class="cart-item-price">{{ number_format($item->unit_price) }} تومان</div>

                                    <!-- نمایش مشخصات محصول -->
                                    <div class="cart-item-attributes mt-2">
                                        @foreach ($item->attributeValues as $val)
                                            @if (in_array(strtolower($val->attribute->name), ['color', 'colour', 'رنگ']))
                                                @php
                                                    $colorValue = $val->value;
                                                    if ($colorValue[0] !== '#') {
                                                        $colorValue = '#' . $colorValue;
                                                    }
                                                @endphp
                                                <div style="display:inline-flex;align-items:center;margin-left:8px;">
                                                    <span
                                                        style="display:inline-block;width:18px;height:18px;border:1px solid #ccc;border-radius:4px;background-color: {{ $colorValue }};margin-left:5px;"></span>
                                                    <span class="ms-1">{{ $val->value }}</span>
                                                </div>
                                            @else
                                                <div class="attribute-item">
                                                    <small>{{ $val->attribute->title }}: {{ $val->value }}</small>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="cart-item-actions">
                                    <form action="{{ route('cart.deleteFromCart', $item) }}" method="POST"
                                        class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn" title="حذف"
                                            onclick="return confirm('آیا مطمئنید که می‌خواهید این آیتم را حذف کنید؟')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <div class="quantity-selector">
                                        <button class="quantity-btn"
                                            onclick="decreaseQuantity({{ $item->id }})">-</button>
                                        <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                            min="1" readonly />
                                        <button class="quantity-btn"
                                            onclick="increaseQuantity({{ $item->id }})">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="cart-actions">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-right me-2"></i>ادامه خرید
                            </a>
                            <form id="clear-cart-form" action="{{ route('cart.clear') }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-trash me-2"></i>پاک کردن سبد خرید
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="empty-cart text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24"
                                fill="none" stroke="#ff9eb7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="20.5" r="1" />
                                <circle cx="18" cy="20.5" r="1" />
                                <path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1" />
                            </svg>
                            <h2
                                style="font-family: 'Dancing Script', cursive; color: var(--text-dark); margin: 1.5rem 0; font-size: 2rem;">
                                سبد خرید شما خالی است!
                            </h2>
                            <p style="color: var(--text-dark); margin-bottom: 2rem;">می‌توانید برای مشاهده محصولات به صفحه
                                فروشگاه بروید</p>
                            <a href="{{ route('products.index') }}"
                                style="display: inline-block; background: linear-gradient(45deg, var(--pink), var(--purple)); color: white; padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                                بازگشت به فروشگاه
                            </a>
                        </div>
                    @endif
                </div>

                @if ($order->items->count() > 0)
                    <!-- فرم تکمیل سفارش -->
                    <div class="checkout-form mt-5">
                        <h3 class="form-title"><i class="bi bi-credit-card me-2"></i>تکمیل سفارش</h3>

                        <form method="POST" action="{{ route('cart.finalize') }}" id="checkoutForm">
                            @csrf

                            <!-- اطلاعات تحویل گیرنده -->
                            <div class="shipping-info-section mb-4">
                                <h4 class="section-title"><i class="bi bi-person me-2"></i>اطلاعات تحویل گیرنده</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="fullname" class="form-label">نام و نام خانوادگی *</label>
                                        <input type="text" id="fullname" name="fullname" class="form-control"
                                            value="{{ old('fullname') }}" required>
                                        @error('fullname')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">شماره تماس *</label>
                                        <input type="tel" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_province_id" class="form-label">استان *</label>
                                        <select id="shipping_province_id" name="shipping_province_id" class="form-select"
                                            required>
                                            <option value="">انتخاب استان</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    {{ old('shipping_province_id') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shipping_province_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_city_id" class="form-label">شهر *</label>
                                        <select id="shipping_city_id" name="shipping_city_id" class="form-select"
                                            required>
                                            <option value="">ابتدا استان را انتخاب کنید</option>
                                        </select>
                                        @error('shipping_city_id')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="postal_code" class="form-label">کد پستی *</label>
                                        <input type="text" id="postal_code" name="postal_code" class="form-control"
                                            value="{{ old('postal_code') }}" maxlength="10" required>
                                        @error('postal_code')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shipping_address" class="form-label">آدرس کامل *</label>
                                        <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                                        @error('shipping_address')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="notes" class="form-label">توضیحات (اختیاری)</label>
                                        <textarea id="notes" name="notes" class="form-control" placeholder="نکاتی که باید بدانیم">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- روش ارسال -->
                            <div class="shipping-methods-section mb-4">
                                <h4 class="section-title"><i class="bi bi-truck me-2"></i>روش ارسال</h4>
                                <div class="shipping-options">
                                    <div class="shipping-option">
                                        <input type="radio" id="shipping-tipex" name="shipping_method"
                                            value="Vanguard_Post" class="shipping-radio" checked>
                                        <label for="shipping-tipex" class="shipping-label">
                                            <div class="shipping-icon"><i class="bi bi-envelope"></i></div>
                                            <div class="shipping-info">
                                                <div class="shipping-title">پست</div>
                                                <div class="shipping-desc">هزینه: 100,000 تومان</div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="shipping-option">
                                        <input type="radio" id="shipping-post" name="shipping_method" value="Courier"
                                            class="shipping-radio">
                                        <label for="shipping-post" class="shipping-label">
                                            <div class="shipping-icon"><i class="bi bi-bicycle"></i></div>
                                            <div class="shipping-info">
                                                <div class="shipping-title">پیک (تهران)</div>
                                                <div class="shipping-desc">تحویل تا 24 ساعت - 50,000 تومان</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('shipping_method')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- روش پرداخت -->
                            <div class="payment-methods-section mb-4">
                                <h4 class="section-title"><i class="bi bi-credit-card me-2"></i>روش پرداخت</h4>
                                <div class="payment-options">
                                    @if ($is_online_pay_active)
                                        <div class="payment-option">
                                            <input type="radio" id="payment-online" name="payment_method"
                                                value="online" class="payment-radio" checked>
                                            <label for="payment-online" class="payment-label">
                                                <div class="payment-icon"><i class="bi bi-credit-card-2-front"></i></div>
                                                <div class="payment-info">
                                                    <div class="payment-title">پرداخت آنلاین</div>
                                                    <div class="payment-desc">درگاه بانکی امن</div>
                                                </div>
                                            </label>
                                        </div>
                                    @else
                                        <div class="payment-option disabled">
                                            <input type="radio" id="payment-online" name="payment_method"
                                                value="online" class="payment-radio" disabled>
                                            <label for="payment-online" class="payment-label disabled">
                                                <div class="payment-icon"><i class="bi bi-credit-card-2-front"></i></div>
                                                <div class="payment-info">
                                                    <div class="payment-title">پرداخت آنلاین</div>
                                                    <div class="payment-desc">موقتاً غیرفعال</div>
                                                </div>
                                            </label>
                                        </div>
                                    @endif

                                    <div class="payment-option">
                                        <input type="radio" id="payment-card" name="payment_method" value="card"
                                            class="payment-radio">
                                        <label for="payment-card" class="payment-label">
                                            <div class="payment-icon"><i class="bi bi-wallet2"></i></div>
                                            <div class="payment-info">
                                                <div class="payment-title">کارت به کارت</div>
                                                <div class="payment-desc">پرداخت با شماره کارت</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- اطلاعات کارت به کارت -->
                            <div class="card-transfer-info" id="card-transfer-info" style="display: none;">
                                <div class="bank-card mb-3">
                                    <div class="bank-card-header">
                                        <div>
                                            <div class="bank-name">بانک رسالت</div>
                                            <div class="card-type">کارت اعتباری</div>
                                        </div>
                                        <img src="{{ asset('site/logos/bank-resalat-min.png') }}" alt="بانک رسالت"
                                            class="bank-logo">
                                    </div>
                                    <div class="card-number">5041 7210 0900 4772</div>
                                    <div class="card-details">
                                        <div class="card-holder">
                                            <span class="card-holder-label">صاحب حساب</span>
                                            علیرضا صفری شمس آبادی
                                        </div>
                                    </div>
                                </div>

                                <div class="transfer-instructions">
                                    <h5 class="instruction-title">راهنمای پرداخت کارت به کارت:</h5>
                                    <div class="instruction-steps">
                                        <div class="step-item">
                                            <i class="bi bi-1-circle"></i>
                                            <span>مبلغ سفارش را به شماره کارت بالا واریز نمایید.</span>
                                        </div>
                                        <div class="step-item">
                                            <i class="bi bi-2-circle"></i>
                                            <span>شماره پیگیری تراکنش را در قسمت توضیحات وارد کنید.</span>
                                        </div>
                                        <div class="step-item">
                                            <i class="bi bi-3-circle"></i>
                                            <span>تصویر فیش واریزی را از طریق پیج اینستاگرام برای ما ارسال کنید.</span>
                                        </div>
                                        <div class="step-item">
                                            <i class="bi bi-4-circle"></i>
                                            <span>پس از تایید پرداخت، سفارش شما ارسال خواهد شد.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn checkout-btn mt-4">
                                <i class="bi bi-lock-fill me-2"></i>تأیید و پرداخت
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="cart-summary sticky-top" style="top: 20px;">
                    <h3 class="summary-title"><i class="bi bi-receipt me-2"></i>خلاصه سفارش</h3>

                    @if ($order->items->count() > 0)
                        <div class="summary-item">
                            <span>قیمت کالاها ({{ $order->items->count() }})</span>
                            <span>{{ number_format($order->total_price) }} تومان</span>
                        </div>

                        <div class="summary-item">
                            <span>تخفیف کالاها</span>
                            <span class="text-danger">-{{ number_format($order->discount_amount) }} تومان</span>
                        </div>

                        <div class="summary-item">
                            <span>هزینه ارسال</span>
                            <span id="shipping-cost">{{ number_format($order->shipment->shipping_cost ?? 0) }}
                                تومان</span>
                        </div>

                        <div class="summary-total">
                            <span>مبلغ قابل پرداخت</span>
                            <span
                                id="final-amount">{{ number_format($order->final_price + ($order->shipment->shipping_cost ?? 0)) }}
                                تومان</span>
                        </div>

                        <div class="discount-section mt-3">
                            <div class="input-group">
                                <input type="text" class="discount-input form-control" placeholder="کد تخفیف"
                                    id="discountCode">
                                <button class="apply-btn btn btn-outline-primary" type="button"
                                    id="applyDiscount">اعمال</button>
                            </div>
                            <div id="discountMessage" class="mt-2"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // بارگذاری شهرها بر اساس استان
            document.getElementById('shipping_province_id').addEventListener('change', function() {
                let provinceId = this.value;
                let citySelect = document.getElementById('shipping_city_id');
                citySelect.innerHTML = '<option value="">لطفاً منتظر بمانید...</option>';

                if (!provinceId) {
                    citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                    return;
                }

                fetch('/api/cities?province_id=' + provinceId)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                        data.forEach(city => {
                            let option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        citySelect.innerHTML = '<option value="">خطا در بارگذاری شهرها</option>';
                        console.error('Error:', error);
                    });
            });

            // مدیریت تغییر روش پرداخت
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const cardInfo = document.getElementById('card-transfer-info');

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'card') {
                        cardInfo.style.display = 'block';
                    } else {
                        cardInfo.style.display = 'none';
                    }
                });
            });

            // مدیریت پرداخت آنلاین غیرفعال
            @if (!$is_online_pay_active)
                const onlinePaymentOption = document.querySelector('#payment-online');
                if (onlinePaymentOption) {
                    onlinePaymentOption.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'info',
                            title: 'پرداخت آنلاین موقتاً غیرفعال است',
                            text: 'سیستم پرداخت آنلاین ما در حال ارتقا می‌باشد و به زودی فعال خواهد شد. لطفاً از روش کارت به کارت استفاده نمایید.',
                            confirmButtonText: 'متوجه شدم',
                            confirmButtonColor: '#8e44ad'
                        });
                    });
                }
            @endif

            // اعمال کد تخفیف
            document.getElementById('applyDiscount').addEventListener('click', function() {
                const code = document.getElementById('discountCode').value.trim();
                const messageDiv = document.getElementById('discountMessage');

                if (!code) {
                    messageDiv.innerHTML =
                        '<div class="alert alert-warning">لطفاً کد تخفیف را وارد کنید</div>';
                    return;
                }

                // نمایش لودینگ
                this.innerHTML =
                    '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i>در حال بررسی...';
                this.disabled = true;

                fetch('{{ route('page.home') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            code: code
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageDiv.innerHTML =
                                `<div class="alert alert-success">${data.message} - ${number_format(data.discount_amount)} تومان تخفیف</div>`;
                            document.querySelector('.summary-total span:last-child').textContent =
                                number_format(data.final_amount) + ' تومان';
                        } else {
                            messageDiv.innerHTML =
                                `<div class="alert alert-danger">${data.message}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        messageDiv.innerHTML =
                            '<div class="alert alert-danger">خطا در اتصال به سرور</div>';
                    })
                    .finally(() => {
                        this.innerHTML = 'اعمال';
                        this.disabled = false;
                    });
            });

            // پاک کردن سبد خرید
            document.getElementById('clear-cart-form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "همه اقلام حذف خواهند شد.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف کن',
                    cancelButtonText: 'لغو',
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // فرمت کردن اعداد
            function number_format(number) {
                return new Intl.NumberFormat('fa-IR').format(number);
            }

            // مدیریت تعداد اقلام
            function increaseQuantity(itemId) {
                const input = document.querySelector(`button[onclick="increaseQuantity(${itemId})"]`).parentElement
                    .querySelector('.quantity-input');
                let currentValue = parseInt(input.value);
                input.value = currentValue + 1;
                updateQuantity(itemId, currentValue + 1);
            }

            function decreaseQuantity(itemId) {
                const input = document.querySelector(`button[onclick="decreaseQuantity(${itemId})"]`).parentElement
                    .querySelector('.quantity-input');
                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateQuantity(itemId, currentValue - 1);
                }
            }

            function updateQuantity(itemId, quantity) {
                fetch('{{ route('page.home') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            item_id: itemId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا',
                                text: data.message || 'خطا در به‌روزرسانی تعداد',
                                confirmButtonColor: '#8e44ad'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: 'خطا در ارتباط با سرور',
                            confirmButtonColor: '#8e44ad'
                        });
                    });
            }
        });
    </script>
@endsection
