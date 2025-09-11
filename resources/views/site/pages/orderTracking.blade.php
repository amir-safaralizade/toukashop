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
        }

        .order-track-container {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin: 2rem auto;
            max-width: 700px;
        }

        .order-track-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }

        .order-track-title::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--pink), var(--purple));
            margin: 1rem auto;
            border-radius: 2px;
        }

        .order-track-form {
            background-color: var(--cream);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
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
            max-width: 400px;
            margin: 0 auto;
            padding: 0.8rem 1rem;
            border: 1px solid var(--light-purple);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--white);
            text-align: center;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(179, 153, 212, 0.2);
        }

        .track-btn {
            display: inline-block;
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: var(--white);
            border: none;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        .track-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(179, 153, 212, 0.4);
        }

        .order-status-container {
            display: none; /* ابتدا مخفی است */
            background-color: var(--cream);
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--light-purple);
        }

        .order-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--purple);
        }

        .order-date {
            color: var(--text-dark);
            opacity: 0.8;
        }

        .status-timeline {
            position: relative;
            padding-right: 3rem;
            margin: 2rem 0;
        }

        .status-step {
            position: relative;
            padding-bottom: 2rem;
            padding-right: 2rem;
        }

        .status-step:last-child {
            padding-bottom: 0;
        }

        .status-step::before {
            content: "";
            position: absolute;
            right: -1.7rem;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: var(--light-purple);
            border: 4px solid var(--white);
            z-index: 2;
        }

        .status-step.active::before {
            background-color: var(--purple);
        }

        .status-step.completed::before {
            background-color: var(--pink);
        }

        .status-step::after {
            content: "";
            position: absolute;
            right: -1.1rem;
            top: 20px;
            width: 2px;
            height: 100%;
            background-color: var(--light-purple);
        }

        .status-step:last-child::after {
            display: none;
        }

        .status-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .status-date {
            font-size: 0.9rem;
            color: var(--text-dark);
            opacity: 0.7;
        }

        .status-description {
            color: var(--text-dark);
            line-height: 1.6;
        }

        .order-details {
            margin-top: 2rem;
        }

        .detail-row {
            display: flex;
            margin-bottom: 1rem;
        }

        .detail-label {
            flex: 0 0 120px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .detail-value {
            flex: 1;
            color: var(--text-dark);
        }

        .no-order {
            text-align: center;
            padding: 2rem;
            color: var(--text-dark);
            display: none; /* ابتدا مخفی است */
        }

        .order-help {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .order-help a {
            color: var(--purple);
            text-decoration: none;
            font-weight: 600;
        }

        .order-help a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .order-track-container {
                padding: 1.5rem;
            }

            .order-track-title {
                font-size: 2rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-date {
                margin-top: 0.5rem;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                margin-bottom: 0.3rem;
            }
        }
    </style>
@endsection

@section('content')
    <main class="py-5" style="background-color: var(--cream); margin-top: 128px">
        <div class="order-track-container">
            <h1 class="order-track-title">پیگیری سفارش</h1>

            <div class="order-track-form">
                <form id="trackOrderForm">
                    <div class="form-group">
                        <label for="orderNumber" class="form-label">لطفاً شماره سفارش خود را وارد کنید</label>
                        <input type="text" id="orderNumber" class="form-control" placeholder="مثال: ORD-123456" required>
                    </div>

                    <button type="submit" class="track-btn">
                        <i class="bi bi-search"></i> پیگیری سفارش
                    </button>
                </form>

                <div class="order-help">
                    شماره سفارش خود را نمی‌دانید؟ <a href="#">کمک می‌خواهید؟</a>
                </div>
            </div>

            <!-- حالت پیش‌فرض (هیچ سفارشی یافت نشد) -->
            <div class="no-order" id="noOrderFound">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#b399d4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
                <h3 style="margin: 1rem 0;">سفارشی یافت نشد!</h3>
                <p>لطفاً شماره سفارش را به درستی وارد کنید.</p>
                <p>در صورت مشکل می‌توانید با پشتیبانی تماس بگیرید.</p>
            </div>

            <!-- حالت نمایش وضعیت سفارش (مخفی در ابتدا) -->
            <div class="order-status-container" id="orderStatusContainer">
                <div class="order-header">
                    <div class="order-number">سفارش #ORD-654321</div>
                    <div class="order-date">تاریخ ثبت: ۱۴۰۲/۰۵/۲۰</div>
                </div>

                <div class="status-timeline">
                    <div class="status-step completed">
                        <div class="status-title">سفارش ثبت شد</div>
                        <div class="status-date">۱۴۰۲/۰۵/۲۰ - ۱۴:۳۰</div>
                        <div class="status-description">سفارش شما با موفقیت در سیستم ثبت شد.</div>
                    </div>

                    <div class="status-step completed">
                        <div class="status-title">تایید پرداخت</div>
                        <div class="status-date">۱۴۰۲/۰۵/۲۰ - ۱۴:۴۵</div>
                        <div class="status-description">پرداخت شما با موفقیت تایید شد.</div>
                    </div>

                    <div class="status-step active">
                        <div class="status-title">آماده‌سازی سفارش</div>
                        <div class="status-date">۱۴۰۲/۰۵/۲۱ - ۰۹:۱۵</div>
                        <div class="status-description">سفارش شما در حال آماده‌سازی است.</div>
                    </div>

                    <div class="status-step">
                        <div class="status-title">تحویل به پست</div>
                        <div class="status-date">---</div>
                        <div class="status-description">در انتظار ارسال</div>
                    </div>

                    <div class="status-step">
                        <div class="status-title">تحویل به مشتری</div>
                        <div class="status-date">---</div>
                        <div class="status-description">در انتظار تحویل</div>
                    </div>
                </div>

                <div class="order-details">
                    <h4 style="color: var(--purple); margin-bottom: 1rem;">جزئیات سفارش</h4>

                    <div class="detail-row">
                        <div class="detail-label">وضعیت سفارش:</div>
                        <div class="detail-value">در حال آماده‌سازی</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">مبلغ کل:</div>
                        <div class="detail-value">۴۵۰,۰۰۰ تومان</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">روش پرداخت:</div>
                        <div class="detail-value">پرداخت آنلاین</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">روش ارسال:</div>
                        <div class="detail-value">پست پیشتاز</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">آدرس ارسال:</div>
                        <div class="detail-value">تهران، خیابان آزادی، کوچه شهید فلانی، پلاک ۱۲، طبقه ۳</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trackForm = document.getElementById('trackOrderForm');
            const orderStatus = document.getElementById('orderStatusContainer');
            const noOrder = document.getElementById('noOrderFound');

            // در حالت واقعی اینجا باید با سرور ارتباط برقرار شود
            trackForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // اینجا فقط برای نمایش نمونه، همیشه وضعیت سفارش را نشان می‌دهد
                // در حالت واقعی باید بررسی شود که آیا سفارش وجود دارد یا نه
                orderStatus.style.display = 'block';
                noOrder.style.display = 'none';

                // برای تست می‌توانید این خط را فعال کنید تا حالت "سفارش یافت نشد" نمایش داده شود
                // orderStatus.style.display = 'none';
                // noOrder.style.display = 'block';
            });
        });
    </script>
@endsection
