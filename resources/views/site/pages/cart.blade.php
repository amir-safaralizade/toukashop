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

        .cart-main {
            padding: 4rem 0;
            background-color: var(--cream);
        }

        .cart-container {
            background-color: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        /* استایل جدول سبد خرید */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .cart-table th {
            text-align: right;
            padding: 1rem;
            color: var(--purple);
            border-bottom: 2px solid rgba(179, 153, 212, 0.2);
        }

        .cart-table td {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(179, 153, 212, 0.1);
            vertical-align: middle;
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* استایل بخش کد تخفیف */
        .discount-section {
            background-color: var(--cream);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .discount-input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 1px solid var(--light-purple);
            border-radius: 10px;
            font-size: 1rem;
        }

        .apply-discount-btn {
            background: linear-gradient(to right, var(--pink), var(--purple));
            color: var(--white);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .apply-discount-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.3);
        }

        /* استایل بخش اطلاعات کاربر */
        .user-info-form {
            background-color: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin-top: 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            border-bottom: 2px solid rgba(179, 153, 212, 0.2);
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--light-purple);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--cream);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(179, 153, 212, 0.2);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* استایل روش‌های پرداخت */
        .payment-methods {
            margin-top: 2rem;
        }

        .payment-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            border: 1px solid var(--light-purple);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: var(--purple);
        }

        .payment-option.active {
            border-color: var(--purple);
            background-color: rgba(179, 153, 212, 0.05);
        }

        .payment-radio {
            margin-left: 1rem;
        }

        .payment-icon {
            font-size: 1.5rem;
            margin-left: 1rem;
            color: var(--purple);
        }

        .payment-label {
            font-weight: 600;
        }

        /* استایل اطلاعات پرداخت کارت به کارت */
        .card-transfer-info {
            background-color: var(--cream);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
            display: none;
        }

        .card-transfer-info.active {
            display: block;
        }

        .bank-card {
            background: linear-gradient(135deg, var(--purple), var(--pink));
            color: var(--white);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .bank-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .card-number {
            font-family: monospace;
            font-size: 1.3rem;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
        }

        .card-owner {
            font-size: 1rem;
        }

        .transfer-instructions {
            line-height: 1.7;
            color: var(--text-dark);
        }

        /* استایل جمع کل و دکمه پرداخت */
        .cart-summary {
            background-color: var(--white);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(179, 153, 212, 0.1);
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            border-bottom: none;
        }

        .summary-total .summary-value {
            color: var(--purple);
            font-size: 1.3rem;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: var(--white);
            border: none;
            padding: 1rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            font-size: 1.1rem;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(179, 153, 212, 0.4);
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .cart-container {
                padding: 1.5rem;
            }

            .cart-table thead {
                display: none;
            }

            .cart-table tr {
                display: block;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid rgba(179, 153, 212, 0.2);
            }

            .cart-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: left !important;
                padding: 0.8rem;
            }

            .cart-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--purple);
                margin-left: 1rem;
            }

            .discount-section {
                flex-direction: column;
            }

            .discount-input {
                width: 100%;
            }

            .apply-discount-btn {
                width: 100%;
            }
        }


        .empty-cart {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
        }

        .empty-cart svg {
            opacity: 0.8;
        }

        .empty-cart a:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
        }




        .payment-option.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            position: relative;
        }

        .payment-option.disabled::after {
            content: "به زودی فعال می‌شود";
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--light-pink);
            color: var(--dark-pink);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .payment-option.disabled:hover {
            border-color: var(--light-purple);
        }

        /* استایل جدید برای کارت بانکی */
        .bank-card {
            background: linear-gradient(135deg, #6e48aa, #9d50bb);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .bank-card::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        .bank-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .bank-logo {
            width: 60px;
            height: auto;
        }

        .bank-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-type {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .card-number {
            font-family: 'Courier New', monospace;
            font-size: 1.4rem;
            letter-spacing: 3px;
            margin: 1.5rem 0;
            text-align: center;
            background: rgba(0, 0, 0, 0.1);
            padding: 0.8rem;
            border-radius: 8px;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
        }

        .card-holder,
        .card-expiry {
            font-size: 0.9rem;
        }

        .card-holder-label,
        .card-expiry-label {
            font-size: 0.7rem;
            opacity: 0.7;
            display: block;
        }

        .transfer-instructions {
            background-color: var(--cream);
            border-radius: 10px;
            padding: 1.2rem;
            margin-top: 1.5rem;
        }

        .instruction-title {
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: var(--purple);
        }

        .instruction-steps {
            padding-right: 1.5rem;
        }

        .instruction-steps li {
            margin-bottom: 0.5rem;
            position: relative;
        }

        .instruction-steps li::before {
            content: "•";
            color: var(--pink);
            font-weight: bold;
            position: absolute;
            right: -1rem;
        }



        @media (max-width: 768px) {
            .bank-card {
                padding: 1rem;
            }

            .bank-card-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .bank-logo {
                width: 50px;
                margin-top: 0.5rem;
            }

            .card-number {
                font-size: 1.1rem;
                letter-spacing: 1px;
                padding: 0.6rem;
                margin: 1rem 0;
            }

            .card-details {
                flex-direction: column;
                gap: 0.5rem;
            }

            .transfer-instructions {
                padding: 1rem;
            }

            .instruction-steps {
                padding-right: 1rem;
            }

            .instruction-steps li {
                margin-bottom: 0.3rem;
            }
        }
    </style>
@endsection

@section('content')
    <main class="cart-main" style="margin-top: 128px">
        <div class="container">
            <div class="cart-container">
                <h1 class="cart-title">تکمیل سفارش</h1>

                <div class="table-responsive">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>محصول</th>
                                <th>مشخصات</th>
                                <th>تعداد</th>
                                <th>قیمت واحد</th>
                                <th>جمع</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                @php
                                    $image = $item->product->firstMedia('main_image');
                                    
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ $image?->full_url }}" alt="{{ $image?->alt ?? $item->product->name }}"
                                            width="80">
                                    </td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
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
                                                        style="display:inline-block;width:18px;height:18px;
                                                        border:1px solid #ccc;border-radius:4px;
                                                        background-color: {{ $colorValue }};
                                                        margin-left:5px;">
                                                    </span>
                                                    
                                                </div>
                                            @else
                                                <div style="margin-left:8px;">
                                                    {{ $val->attribute->title }}: {{ $val->value }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price) }} تومان</td>
                                    <td>{{ number_format($item->total_price) }} تومان</td>
                                    <td>
                                        <form action="{{ route('cart.deleteFromCart', $item) }}" method="POST"
                                            onsubmit="return confirm('آیا مطمئنید که می‌خواهید این آیتم را حذف کنید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                @if ($order->items->count() > 0)
                    <form id="clear-cart-form" action="{{ route('cart.clear') }}" method="POST" style="padding: 1.5rem">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger mt-3">
                            <i class="bi bi-trash"></i> خالی کردن سبد خرید
                        </button>
                    </form>



                    <div class="discount-section my-4">
                        <input type="text" class="discount-input" placeholder="کد تخفیف خود را وارد کنید">
                        <button type="button" class="apply-discount-btn btn btn-outline-primary">اعمال کد تخفیف</button>
                    </div>


                    <form method="POST" action="{{ route('cart.finalize') }}">
                        @csrf

                        <div class="user-info-form">
                            <h3 class="form-title">اطلاعات تحویل گیرنده</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fullname" class="form-label">نام و نام خانوادگی *</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control"
                                        value="{{ old('fullname') }}" required>
                                    @error('fullname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">شماره تماس *</label>
                                    <input type="tel" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="shipping_province_id" class="form-label">استان *</label>
                                    <select id="shipping_province_id" name="shipping_province_id" class="form-control"
                                        required>
                                        <option value="">انتخاب استان</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('shipping_province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_province_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_city_id" class="form-label">شهر *</label>
                                    <select id="shipping_city_id" name="shipping_city_id" class="form-control" required>
                                        <option value="">ابتدا استان را انتخاب کنید</option>
                                    </select>
                                    @error('shipping_city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="postal_code" class="form-label">کد پستی *</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control"
                                    value="{{ old('postal_code') }}" maxlength="10" required>
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="shipping_address" class="form-label">آدرس کامل *</label>
                                <textarea id="shipping_address" name="shipping_address" class="form-control" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="notes" class="form-label">توضیحات (اختیاری)</label>
                                <textarea id="notes" name="notes" class="form-control" placeholder="نکاتی که باید بدانیم">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="shipping-methods mt-4">
                            <h3 class="shipping-title">روش ارسال</h3>
                            <div class="shipping-option">
                                <input type="radio" id="shipping-tipex" name="shipping_method" value="Vanguard_Post"
                                    class="shipping-radio" checked>
                                <label for="shipping-tipex">پست (هزینه: 100,000 تومان)</label>
                            </div>
                            <div class="shipping-option">
                                <input type="radio" id="shipping-post" name="shipping_method" value="Courier"
                                    class="shipping-radio">
                                <label for="shipping-post">پیک (فقط مخصوص تهران-تحویل تا 24 ساعت کاری - 50,000
                                    تومان)</label>
                            </div>
                            @error('shipping_method')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="payment-methods mt-4">
                            <h3 class="payment-title">روش پرداخت</h3>

                            @if ($is_online_pay_active)
                                <div class="payment-option active">
                                    <input type="radio" id="payment-online" name="payment_method" value="online"
                                        class="payment-radio" checked>
                                    <label for="payment-online">پرداخت آنلاین (درگاه بانکی)</label>
                                </div>
                            @else
                                <div class="payment-option disabled">
                                    <input type="radio" id="payment-online" name="payment_method" value="online"
                                        class="payment-radio" disabled>
                                    <label for="payment-online">پرداخت آنلاین (درگاه بانکی)</label>
                                </div>
                            @endif

                            <div class="payment-option">
                                <input type="radio" id="payment-card" name="payment_method" value="card"
                                    class="payment-radio">
                                <label for="payment-card">کارت به کارت</label>
                                <div class="card-transfer-info" id="card-transfer-info" style="display: none;">
                                    <div class="bank-card">
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
                                            {{-- <div class="card-expiry">
                                                <span class="card-expiry-label">شماره شبا</span>
                                                IR580120000000007205314001
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="transfer-instructions">
                                        <h4 class="instruction-title">راهنمای پرداخت کارت به کارت:</h4>
                                        <ol class="instruction-steps">
                                            <li>مبلغ سفارش را به شماره کارت بالا واریز نمایید.</li>
                                            <li>شماره پیگیری تراکنش را در قسمت توضیحات وارد کنید.</li>
                                            <li>تصویر فیش واریزی را از طریق پیج اینستاگرام برای ما ارسال کنید.</li>
                                            <li>پس از تایید پرداخت، سفارش شما ارسال خواهد شد.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="cart-summary mt-4">
                            <div class="summary-row">
                                <span>جمع کل:</span>
                                <span>{{ number_format($order->total_price) }} تومان</span>
                            </div>
                            <div class="summary-row">
                                <span>تخفیف:</span>
                                <span>{{ number_format($order->discount_amount) }} تومان</span>
                            </div>
                            <div class="summary-row">
                                <span>هزینه ارسال:</span>
                                <span>{{ number_format($order->shipment->shipping_cost ?? 0) }} تومان</span>
                            </div>
                            <div class="summary-row summary-total">
                                <strong>مبلغ قابل پرداخت:</strong>
                                <strong>{{ number_format($order->final_price + ($order->shipment->shipping_cost ?? 0)) }}
                                    تومان</strong>
                            </div>

                            <button type="submit" class="checkout-btn btn btn-success mt-3">
                                <i class="bi bi-lock-fill"></i> تکمیل پرداخت
                            </button>
                        </div>
                    </form>
                @else
                    <div class="empty-cart" style="text-align: center; padding: 4rem 0;">
                        <div style="max-width: 400px; margin: 0 auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24"
                                fill="none" stroke="#ff9eb7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="20.5" r="1" />
                                <circle cx="18" cy="20.5" r="1" />
                                <path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1" />
                            </svg>
                            <h2
                                style="font-family: 'Dancing Script', cursive; color: var(--text-dark); margin: 1.5rem 0; font-size: 2rem;">
                                سبد خرید شما خالی است!</h2>
                            <p style="color: var(--text-dark); margin-bottom: 2rem;">می‌توانید برای مشاهده محصولات به
                                صفحه فروشگاه بروید</p>
                            <a href="{{ route('products.index') }}"
                                style="display: inline-block; background: linear-gradient(45deg, var(--pink), var(--purple)); color: white; padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                                بازگشت به فروشگاه
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.getElementById('shipping_province_id').addEventListener('change', function() {
            let provinceId = this.value;
            let citySelect = document.getElementById('shipping_city_id');
            citySelect.innerHTML = '<option value="">لطفاً منتظر بمانید...</option>';

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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelector('.apply-discount-btn').addEventListener('click', function() {
                const code = document.querySelector('.discount-input').value;
                if (!code) return alert('لطفاً کد تخفیف را وارد کنید');
                alert('کد تخفیف اعمال شد (نمایشی)');
            });

            document.getElementById('clear-cart-form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "همه اقلام حذف خواهند شد.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله، حذف کن',
                    cancelButtonText: 'لغو',
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endsection
