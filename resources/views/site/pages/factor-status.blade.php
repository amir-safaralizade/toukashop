@extends('layout.app')

@section('styles')
    <style>
        .transaction-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .transaction-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .status-success {
            background-color: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-block;
            margin: 15px 0;
        }

        .status-failed {
            background-color: #dc3545;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-block;
            margin: 15px 0;
        }

        .transaction-details {
            padding: 30px;
        }

        .detail-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .detail-title {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }

        .detail-item:not(:last-child) {
            border-bottom: 1px dashed #eee;
        }

        .order-items {
            margin: 30px 0;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-bottom: 15px;
        }

        .order-item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-left: 15px;
        }

        .order-item-info {
            flex: 1;
        }

        .order-item-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .order-item-price {
            color: var(--primary-color);
            font-weight: 700;
        }

        .timeline {
            position: relative;
            padding: 20px 0;
            margin: 30px 0;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            right: 15px;
            width: 3px;
            height: 100%;
            background-color: var(--secondary-color);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-right: 35px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            top: 0;
            right: 6px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            border: 4px solid white;
        }

        .timeline-content {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .timeline-date {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 5px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
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

        .success-animation {
            animation: successPulse 2s ease-in-out;
        }

        @keyframes successPulse {
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

        /* Responsive */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            .detail-item {
                flex-direction: column;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }

            .order-item-img {
                margin-left: 0;
                margin-bottom: 15px;
            }

            body {
                padding-top: 70px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div
                    class="transaction-container {{ $transaction->status === 'success' ? 'success-animation' : ($transaction->status === 'pending' ? 'pending-animation' : 'failed-animation') }}">
                    <div class="transaction-header">
                        @if ($transaction->gateway === 'manual' && $transaction->status === 'pending')
                            <h2 class="mb-3"><i class="bi bi-clock-history me-2"></i>در انتظار تایید پرداخت</h2>
                            <div class="status-pending">
                                <i class="bi bi-clock me-2"></i>منتظر تایید پرداخت کارت‌به‌کارت
                            </div>
                            <p class="mb-0">درخواست شما برای پرداخت از طریق کارت‌به‌کارت با موفقیت ثبت شد</p>
                            <p class="mt-2">
                                لطفاً پس از انجام واریز، رسید پرداخت را به همراه شماره سفارش خود
                                <span class="text-success">{{ '(' . $transaction->payable->tracking_code . ')' }}</span>
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
                                را
                                از طریق تلگرام یا سایر پیام رسان ها برای ما ارسال کنید تا سفارش شما تایید و پردازش شود.
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
                            <p class="mb-0">متاسفانه پرداخت شما با مشکل مواجه شد</p>
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
                                    {{ $transaction->status === 'pending' ? 'در انتظار تایید' : ($transaction->status === 'success' ? 'موفق' : 'ناموفق') }}
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
                            <!-- آیتم های سفارش -->
                            <div class="order-items">
                                <h4 class="detail-title">آیتم های سفارش</h4>

                                @foreach ($order->items as $item)
                                    <div class="order-item">
                                        <img src="{{ $item->product->firstMedia('main_image')->full_url }}"
                                            class="order-item-img" alt="{{ $item->product->name }}">
                                        <div class="order-item-info">
                                            <h5 class="order-item-title">{{ $item->product->name }}</h5>
                                            <p class="mb-1 text-muted">تعداد: {{ $item->quantity }} عدد</p>
                                            @if ($item->attributeValues->count() > 0)
                                                <p class="mb-1 text-muted small">
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
                                        <p class="mb-0">پرداخت موفقیت آمیز بود</p>
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
                                        <p class="mb-0">تایید نهایی سبد خرید</p>
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
                        @elseif($transaction->status === 'pending')
                            <!-- زمانبندی سفارش - در انتظار -->
                            <div class="timeline">
                                <h4 class="detail-title">وضعیت سفارش</h4>

                                <div class="timeline-item active">
                                    <div class="timeline-dot pending"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">{{ $transaction->created_at->format('Y/m/d - H:i') }}
                                        </div>
                                        <p class="mb-0">در انتظار تایید پرداخت</p>
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
                                        <p class="mb-0">تایید نهایی سبد خرید</p>
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

                        <!-- دکمه های اقدام -->
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
                            @elseif($transaction->gateway === 'manual' && $transaction->status === 'pending')
                                <button class="btn btn-warning me-2" onclick="uploadReceipt()">
                                    <i class="bi bi-upload me-2"></i>آپلود رسید
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-cart me-2"></i>ویرایش سفارش
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-house me-2"></i>بازگشت به فروشگاه
                                </a>
                            @else
                                <a href="{{ route('cart.index') }}" class="btn btn-primary me-2">
                                    <i class="bi bi-arrow-repeat me-2"></i>تلاش مجدد
                                </a>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-cart me-2"></i>بازگشت به سبد خرید
                                </a>
                                <a href="{{ route('contact') }}" class="btn btn-outline-danger">
                                    <i class="bi bi-headset me-2"></i>تماس با پشتیبانی
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
            // مدیریت وضعیت تراکنش بر اساس URL parameter (اختیاری)
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            // تابع دانلود فاکتور (PDF)
            function downloadInvoice() {
                // می‌توانید از کتابخانه jsPDF یا لینک دانلود استفاده کنید
                Swal.fire({
                    icon: 'info',
                    title: 'دانلود فاکتور',
                    text: 'فاکتور در حال آماده‌سازی است...',
                    confirmButtonText: 'باشه',
                    confirmButtonColor: '#8e44ad'
                });
                // window.open('/invoices/download/{{ $transaction->id }}', '_blank');
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
                    confirmButtonColor: '#28a745',
                    cancelButtonText: 'لغو',
                    preConfirm: () => {
                        const file = document.getElementById('receiptFile').files[0];
                        const trackingNumber = document.getElementById('trackingNumber').value;

                        if (!file || !trackingNumber) {
                            Swal.showValidationMessage('لطفاً فایل رسید و شماره پیگیری را وارد کنید');
                            return false;
                        }

                        // آپلود با Ajax
                        const formData = new FormData();
                        formData.append('receipt', file);
                        formData.append('tracking_number', trackingNumber);
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch('{{ route('transactions.uploadReceipt', $transaction->id) }}', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'موفقیت آمیز',
                                        text: 'رسید با موفقیت آپلود شد و در حال بررسی است',
                                        confirmButtonColor: '#8e44ad'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطا',
                                        text: data.message || 'خطا در آپلود رسید',
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
            }

            // انیمیشن timeline
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate');
                }, index * 200);
            });

            // چاپ صفحه
            function printTransaction() {
                window.print();
            }
        });
    </script>
@endsection
