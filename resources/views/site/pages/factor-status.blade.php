@extends('layout.app')

@section('styles')
    <style>
        .transaction-container {
            background: var(--light-color);
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 40px;
            padding: 20px;
        }

        .transaction-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--light-color);
            padding: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .transaction-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .status-success,
        .status-pending,
        .status-failed {
            display: inline-flex;
            align-items: center;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            margin: 10px 0;
            color: var(--light-color);
        }

        .status-success {
            background: var(--success);
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .status-pending {
            background: var(--accent-color);
            color: var(--dark-color);
            box-shadow: 0 4px 10px rgba(255, 230, 109, 0.3);
        }

        .status-failed {
            background: var(--danger);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .transaction-details {
            padding: 30px;
        }

        .detail-card {
            background: var(--cream);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .detail-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--purple);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--pink);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .detail-item span:first-child {
            font-weight: 600;
            color: var(--dark-color);
        }

        .detail-item span:last-child {
            font-weight: 500;
        }

        .detail-item:not(:last-child) {
            border-bottom: 1px dashed var(--pink);
        }

        .order-items {
            margin: 40px 0;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 15px;
            background: var(--light-color);
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .order-item:hover {
            transform: translateY(-5px);
        }

        .order-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            margin-left: 20px;
            border: 1px solid var(--cream);
        }

        .order-item-info {
            flex: 1;
        }

        .order-item-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .order-item-info p {
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .order-item-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .timeline {
            position: relative;
            padding: 30px 0;
            margin: 40px 0;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            right: 20px;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--secondary-color), var(--primary-color));
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-right: 50px;
        }

        .timeline-item.active .timeline-dot {
            background: var(--success);
            border-color: var(--light-color);
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        }

        .timeline-item.pending .timeline-dot {
            background: var(--accent-color);
            border-color: var(--light-color);
            box-shadow: 0 0 10px rgba(255, 230, 109, 0.5);
        }

        .timeline-dot {
            position: absolute;
            top: 5px;
            right: 11px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--secondary-color);
            border: 4px solid var(--light-color);
            transition: all 0.3s ease;
        }

        .timeline-content {
            background: var(--light-color);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--cream);
        }

        .timeline-date {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--purple);
            margin-bottom: 8px;
        }

        .timeline-content p {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-success,
        .btn-warning,
        .btn-outline-primary,
        .btn-outline-danger {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--pink);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-success {
            background: var(--success);
            border-color: var(--success);
        }

        .btn-success:hover {
            background: darken(var(--success), 10%);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-warning {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--dark-color);
        }

        .btn-warning:hover {
            background: darken(var(--accent-color), 10%);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 230, 109, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--light-color);
            transform: translateY(-3px);
        }

        .btn-outline-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            color: var(--light-color);
            transform: translateY(-3px);
        }

        .contact-buttons a {
            font-size: 0.95rem;
            padding: 10px 20px;
        }

        .pet-icon {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            z-index: -1;
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-animation {
            animation: successPulse 2s ease-in-out;
        }

        .pending-animation .timeline-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .transaction-container {
                padding: 15px;
            }

            .transaction-header {
                padding: 20px;
            }

            .transaction-header h2 {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }

            .order-item-img {
                margin-left: 0;
                margin-bottom: 15px;
                width: 120px;
                height: 120px;
            }

            .timeline:before {
                right: 15px;
            }

            .timeline-dot {
                right: 6px;
            }

            .timeline-item {
                padding-right: 40px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="mt-128"></div>
    <!-- Floating pet icons -->
    <i class="bi bi-egg-fried pet-icon floating" style="top: 10%; left: 5%; animation-delay: 0.2s"></i>
    <i class="bi bi-bone pet-icon floating" style="top: 80%; right: 10%; animation-delay: 0.5s"></i>
    <i class="bi bi-balloon-heart pet-icon floating" style="top: 40%; right: 5%; animation-delay: 0.7s"></i>
    <i class="bi bi-gem pet-icon floating" style="bottom: 15%; left: 15%; animation-delay: 0.3s"></i>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div
                    class="transaction-container {{ $transaction->status === 'success' ? 'success-animation' : ($transaction->gateway === 'manual' && $transaction->status === 'pending' ? 'pending-animation' : 'failed-animation') }}">
                    <div class="transaction-header">
                        @if ($transaction->gateway === 'manual' && $transaction->status === 'pending')
                            <h2 class="mb-3"><i class="bi bi-clock-history me-2"></i>در انتظار تایید پرداخت</h2>
                            <div class="status-pending">
                                <i class="bi bi-clock me-2"></i>منتظر تایید پرداخت کارت‌به‌کارت
                            </div>
                            <p class="mb-0">درخواست شما برای پرداخت از طریق کارت‌به‌کارت با موفقیت ثبت شد</p>
                            <p class="mt-2">
                                لطفاً پس از انجام واریز، رسید پرداخت را به همراه شماره سفارش خود
                                <span
                                    class="text-success fw-bold">{{ '(' . $transaction->payable->tracking_code . ')' }}</span>
                                برای تیم پشتیبانی ارسال نمایید.
                            </p>
                            <div class="contact-buttons mt-3">
                                <a href="tel:09053621387" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-telephone me-1"></i>0905-362-1387
                                </a>
                                <a href="tel:09920805054" class="btn btn-outline-primary">
                                    <i class="bi bi-telephone me-1"></i>0992-080-5054
                                </a>
                            </div>
                            <p class="mt-3">
                                در صورتی که هنوز مبلغ را واریز نکرده‌اید، لطفاً در اسرع وقت پرداخت را انجام دهید و سپس رسید
                                را از طریق تلگرام یا سایر پیام‌رسان‌ها برای ما ارسال کنید تا سفارش شما تأیید و پردازش شود.
                            </p>
                        @elseif($transaction->status === 'success')
                            <h2 class="mb-3"><i class="bi bi-check-circle-fill me-2"></i>تراکنش موفق</h2>
                            <div class="status-success">
                                <i class="bi bi-check-lg me-2"></i>پرداخت با موفقیت انجام شد
                            </div>
                            <p class="mb-0">سفارش شما ثبت شد و در حال پردازش است</p>
                        @else
                            <h2 class="mb-3"><i class="bi bi-x-circle-fill me-2"></i>تراکنش ناموفق</h2>
                            <div class="status-failed">
                                <i class="bi bi-x-lg me-2"></i>پرداخت انجام نشد
                            </div>
                            <p class="mb-0">متأسفانه پرداخت شما با مشکل مواجه شد</p>
                        @endif
                    </div>

                    <div class="transaction-details">
                        <!-- اطلاعات تراکنش -->
                        <div class="detail-card">
                            <h4 class="detail-title">اطلاعات تراکنش</h4>
                            <div class="detail-item">
                                <span>شماره تراکنش:</span>
                                <span class="fw-bold">{{ $transaction->our_token ?? '-' }}</span>
                            </div>
                            @if ($transaction->status === 'success')
                                <div class="detail-item">
                                    <span>شماره سفارش:</span>
                                    <span class="fw-bold">{{ $transaction->payable->tracking_code }}</span>
                                </div>
                            @endif
                            <div class="detail-item">
                                <span>تاریخ تراکنش:</span>
                                <span>{{ $transaction->created_at->format('Y/m/d - H:i') }}</span>
                            </div>
                            <div class="detail-item">
                                <span>مبلغ تراکنش:</span>
                                <span class="fw-bold {{ $transaction->status === 'success' ? 'text-success' : '' }}">
                                    {{ number_format($transaction->amount) }} تومان
                                </span>
                            </div>
                            <div class="detail-item">
                                <span>روش پرداخت:</span>
                                <span>{{ $transaction->gateway === 'manual' ? 'کارت به کارت' : 'درگاه پرداخت آنلاین' }}</span>
                            </div>
                            <div class="detail-item">
                                <span>وضعیت تراکنش:</span>
                                <span
                                    class="badge {{ $transaction->status === 'success' ? 'bg-success' : ($transaction->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $transaction->status === 'pending' ? 'در انتظار تأیید' : ($transaction->status === 'success' ? 'موفق' : 'ناموفق') }}
                                </span>
                            </div>
                        </div>

                        @if ($transaction->status === 'success' || ($transaction->gateway === 'manual' && $transaction->status === 'pending'))
                            @php($order = $transaction->payable)
                            <!-- اطلاعات مشتری -->
                            <div class="detail-card">
                                <h4 class="detail-title">اطلاعات مشتری</h4>
                                <div class="detail-item">
                                    <span>نام و نام خانوادگی:</span>
                                    <span>{{ $order->customer_name ?? 'نامشخص' }}</span>
                                </div>
                                <div class="detail-item">
                                    <span>شماره تماس:</span>
                                    <span>{{ $order->customer_phone ?? 'نامشخص' }}</span>
                                </div>
                                @if ($order->customer_email)
                                    <div class="detail-item">
                                        <span>آدرس ایمیل:</span>
                                        <span>{{ $order->customer_email }}</span>
                                    </div>
                                @endif
                                <div class="detail-item">
                                    <span>آدرس ارسال:</span>
                                    <span>{{ $order->shipping_address ?? 'نامشخص' }}</span>
                                </div>
                                @if ($order->shipping_city)
                                    <div class="detail-item">
                                        <span>شهر:</span>
                                        <span>{{ $order->shipping_city->name ?? ($order->shipping_city ?? 'نامشخص') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if ($transaction->status === 'success' || ($transaction->gateway === 'manual' && $transaction->status === 'pending'))
                            <!-- آیتم‌های سفارش -->
                            <div class="order-items">
                                <h4 class="detail-title">آیتم‌های سفارش</h4>
                                @foreach ($order->items as $item)
                                    <div class="order-item">
                                        <img src="{{ $item->product->firstMedia('main_image')->full_url }}"
                                            class="order-item-img" alt="{{ $item->product->name }}">
                                        <div class="order-item-info">
                                            <h5 class="order-item-title">{{ $item->product->name }}</h5>
                                            <p class="mb-1">تعداد: {{ $item->quantity }} عدد</p>
                                            @if ($item->attributeValues->count() > 0)
                                                <p class="mb-1 small">
                                                    مشخصات:
                                                    @foreach ($item->attributeValues as $attrValue)
                                                        {{ $attrValue->attribute->title }}: {{ $attrValue->value }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </p>
                                            @endif
                                        </div>
                                        <div class="order-item-price">{{ number_format($item->total_price) }} تومان</div>
                                    </div>
                                @endforeach
                                <div class="detail-item mt-4">
                                    <span>هزینه ارسال:</span>
                                    <span>{{ number_format($order->shipment->shipping_cost ?? 0) }} تومان</span>
                                </div>
                                @if ($order->discount_amount > 0)
                                    <div class="detail-item">
                                        <span>تخفیف:</span>
                                        <span class="text-danger">-{{ number_format($order->discount_amount) }}
                                            تومان</span>
                                    </div>
                                @endif
                                <div class="detail-item fw-bold fs-5">
                                    <span>جمع کل:</span>
                                    <span
                                        class="text-success">{{ number_format($order->final_price + ($order->shipment->shipping_cost ?? 0)) }}
                                        تومان</span>
                                </div>
                            </div>
                        @endif

                        @if ($transaction->status === 'success')
                            <!-- زمانبندی سفارش -->
                            <div class="timeline">
                                <h4 class="detail-title">وضعیت سفارش</h4>
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">{{ $transaction->created_at->format('Y/m/d - H:i') }}
                                        </div>
                                        <p class="mb-0">پرداخت موفقیت‌آمیز بود</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(2)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">در حال انتقال به درگاه پرداخت</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(5)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">تأیید نهایی سبد خرید</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(15)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">سبد خرید ایجاد شد</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($transaction->gateway === 'manual' && $transaction->status === 'pending')
                            <!-- زمانبندی سفارش - در انتظار -->
                            <div class="timeline">
                                <h4 class="detail-title">وضعیت سفارش</h4>
                                <div class="timeline-item active pending">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">{{ $transaction->created_at->format('Y/m/d - H:i') }}
                                        </div>
                                        <p class="mb-0">در انتظار تأیید پرداخت</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(2)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">درخواست پرداخت کارت به کارت</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(5)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">تأیید نهایی سبد خرید</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">
                                            {{ $transaction->created_at->subMinutes(15)->format('Y/m/d - H:i') }}</div>
                                        <p class="mb-0">سبد خرید ایجاد شد</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- دکمه‌های اقدام -->
                        <div class="action-buttons mt-4">
                            @if ($transaction->status === 'success')
                                <button class="btn btn-primary me-2" onclick="window.print()">
                                    <i class="bi bi-printer me-2"></i>چاپ رسید
                                </button>
                                <button class="btn btn-outline-primary me-2" onclick="downloadInvoice()">
                                    <i class="bi bi-receipt me-2"></i>دانلود فاکتور
                                </button>
                                <a href="{{ route('page.orderTracking', $order->tracking_code) }}"
                                    class="btn btn-success me-2">
                                    <i class="bi bi-truck me-2"></i>پیگیری سفارش
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-2"></i>بازگشت به فروشگاه
                                </a>
                            @else
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-2"></i>بازگشت به فروشگاه
                                </a>
                                <a href="{{ route('page.home') }}" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-home me-2"></i>برو به صفحه اصلی
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تابع دانلود فاکتور (PDF)
            function downloadInvoice() {
                Swal.fire({
                    icon: 'info',
                    title: 'دانلود فاکتور',
                    text: 'فاکتور در حال آماده‌سازی است...',
                    confirmButtonText: 'باشه',
                    confirmButtonColor: var (--purple)
                });
            }

            // تابع آپلود رسید
            function uploadReceipt() {
                Swal.fire({
                    title: 'آپلود رسید پرداخت',
                    html: `
                        <div class="mb-3">
                            <label class="form-label">انتخاب فایل رسید:</label>
                            <input type="file" class="form-control" id="receiptFile" accept="image/*,.pdf">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">شماره پیگیری تراکنش:</label>
                            <input type="text" class="form-control" id="trackingNumber" placeholder="مثال: 123456789">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'آپلود',
                    confirmButtonColor: var (--success),
                    cancelButtonText: 'لغو',
                    cancelButtonColor: var (--danger),
                    preConfirm: () => {
                        const file = document.getElementById('receiptFile').files[0];
                        const trackingNumber = document.getElementById('trackingNumber').value;

                        if (!file || !trackingNumber) {
                            Swal.showValidationMessage('لطفاً فایل رسید و شماره پیگیری را وارد کنید');
                            return false;
                        }

                        const formData = new FormData();
                        formData.append('receipt', file);
                        formData.append('tracking_number', trackingNumber);
                        formData.append('_token', '{{ csrf_token() }}');

                        return fetch('{{ route('page.home', $transaction->id) }}', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    throw new Error(data.message || 'خطا در آپلود رسید');
                                }
                                return data;
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'موفقیت‌آمیز',
                            text: 'رسید با موفقیت آپلود شد و در حال بررسی است',
                            confirmButtonColor: var (--purple)
                        });
                    }
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: error.message || 'خطا در ارتباط با سرور',
                        confirmButtonColor: var (--purple)
                    });
                });
            }

            // انیمیشن timeline
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate');
                }, index * 200);
            });
        });
    </script>
@endsection
