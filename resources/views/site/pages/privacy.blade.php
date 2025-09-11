@extends('layout.app')

@section('styles')
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --accent-color: #ffe66d;
            --dark-color: #292f36;
            --light-color: #f7fff7;
            --text-dark: #333;
            --cream: #f8f1e9;
            --pink: #ff9eb7;
            --purple: #8e44ad;
            --success: #28a745;
            --danger: #dc3545;
        }


        .privacy-container {
            background: var(--light-color);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin: 3rem auto;
            max-width: 1000px;
            position: relative;
            overflow: hidden;
        }

        .privacy-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--purple);
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .privacy-title::after {
            content: '';
            display: block;
            width: 120px;
            height: 5px;
            background: linear-gradient(to right, var(--pink), var(--primary-color));
            margin: 1rem auto;
            border-radius: 3px;
        }

        .privacy-intro {
            font-size: 1.15rem;
            line-height: 1.9;
            color: var(--text-dark);
            background: var(--cream);
            padding: 2rem;
            border-radius: 15px;
            border-left: 5px solid var(--secondary-color);
            margin-bottom: 2.5rem;
            font-weight: 500;
        }

        .privacy-section {
            margin-bottom: 3rem;
        }

        .privacy-section h4 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--purple);
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px dashed var(--pink);
            position: relative;
        }

        .privacy-section h4::before {
            content: '🐾';
            margin-left: 0.7rem;
            font-size: 1.8rem;
        }

        .privacy-list {
            background: var(--cream);
            border-radius: 12px;
            padding: 1.8rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            background: transparent;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1.05rem;
            color: var(--text-dark);
            position: relative;
            padding-right: 2.5rem;
        }

        .list-group-item::before {
            content: '🐶';
            color: var(--primary-color);
            font-size: 1.4rem;
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .list-unstyled li {
            padding: 0.8rem 0;
            font-size: 1.05rem;
            color: var(--text-dark);
            position: relative;
            padding-right: 2.5rem;
            font-weight: 500;
        }

        .list-unstyled li::before {
            content: '✔';
            color: var(--success);
            font-weight: bold;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .privacy-contact {
            background: linear-gradient(135deg, var(--pink), var(--secondary-color));
            padding: 2rem;
            border-radius: 15px;
            margin-top: 2.5rem;
            color: var(--text-dark);
        }

        .privacy-contact li {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .privacy-contact a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .privacy-contact a:hover {
            color: var(--purple);
            text-decoration: underline;
        }

        .privacy-alert {
            background: var(--cream);
            border: 1px solid var(--pink);
            border-left: 5px solid var(--primary-color);
            border-radius: 15px;
            padding: 2rem;
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: center;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
        }

        .privacy-alert::after {
            content: '🐱';
            position: absolute;
            font-size: 6rem;
            opacity: 0.1;
            bottom: -1.5rem;
            left: -1.5rem;
            z-index: 0;
        }

        hr {
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--secondary-color), transparent);
            margin: 3rem 0;
        }

        .pet-icon {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.1;
            z-index: -1;
        }

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

        @media (max-width: 768px) {
            .privacy-container {
                padding: 1.5rem;
                margin: 1.5rem;
            }

            .privacy-title {
                font-size: 2.2rem;
            }

            .privacy-section h4 {
                font-size: 1.4rem;
            }

            .privacy-intro {
                font-size: 1rem;
                padding: 1.5rem;
            }

            .privacy-alert {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Floating pet icons -->
    <i class="bi bi-egg-fried pet-icon floating" style="top: 10%; left: 5%; animation-delay: 0.2s"></i>
    <i class="bi bi-bone pet-icon floating" style="top: 80%; right: 10%; animation-delay: 0.5s"></i>
    <i class="bi bi-balloon-heart pet-icon floating" style="top: 40%; right: 5%; animation-delay: 0.7s"></i>
    <i class="bi bi-gem pet-icon floating" style="bottom: 15%; left: 15%; animation-delay: 0.3s"></i>

    <main class="py-5" style="background-color: var(--cream);">
        <div class="privacy-container">
            <h1 class="privacy-title">حریم خصوصی در توکاشاپ</h1>

            <p class="privacy-intro">سلام دوست عزیز توکایی! 🐾 ما تو <strong>توکاشاپ</strong>، یه فروشگاه آنلاین پر از عشق و
                توجه به حیوانات خانگی، خیلی جدی به حفظ حریم خصوصی شما پایبندیم. این صفحه رو آماده کردیم تا به زبان ساده و
                شفاف بهت بگیم چه اطلاعاتی ازت جمع می‌کنیم، چطور ازشون استفاده می‌کنیم و چطور از امنیتشون مطمئن می‌شیم.</p>

            <hr>

            <div class="privacy-section">
                <h4>چه اطلاعاتی از شما جمع‌آوری می‌کنیم؟</h4>
                <ul class="list-group list-group-flush privacy-list">
                    <li class="list-group-item">نام و نام خانوادگی</li>
                    <li class="list-group-item">شماره موبایل</li>
                    <li class="list-group-item">آدرس ایمیل</li>
                    <li class="list-group-item">آدرس ارسال کالا</li>
                    <li class="list-group-item">اطلاعات مربوط به سفارش‌ها (مثل غذا، اسباب‌بازی یا لوازم حیوانات)</li>
                    <li class="list-group-item">اطلاعات فنی مثل آدرس IP، نوع مرورگر و کوکی‌ها</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h4>چرا این اطلاعات رو جمع می‌کنیم؟</h4>
                <ul class="list-unstyled privacy-list">
                    <li>برای پردازش سریع و دقیق سفارش‌هات</li>
                    <li>برای بهتر کردن تجربه خریدت تو توکاشاپ</li>
                    <li>برای ارسال پیشنهادهای ویژه و تخفیف‌های پشمالو (اگه خودت بخوای)</li>
                    <li>برای جلوگیری از هرگونه سوءاستفاده یا مشکل امنیتی</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h4>اطلاعاتت پیش ما امنه! 🐶❤️</h4>
                <p>ما از روش‌های امنیتی پیشرفته استفاده می‌کنیم تا اطلاعاتت همیشه محفوظ بمونه. خیالت راحت باشه، هیچ‌وقت
                    اطلاعاتت رو بدون اجازه‌ات به شخص یا شرکتی نمی‌دیم، مگر اینکه قانون مجبورمون کنه.</p>
            </div>

            <div class="privacy-section">
                <h4>کوکی‌ها چی هستن؟</h4>
                <p>کوکی‌ها فایل‌های کوچیکی هستن که تو مرورگرت ذخیره می‌شن و کمک می‌کنن سایت ما سریع‌تر و بهتر برات کار کنه.
                    مثلاً یادش می‌مونه تو کدوم شهر هستی یا چه مدل اسباب‌بازی برای سگ یا گربت دوست داری. اگه نخوای، می‌تونی
                    از تنظیمات مرورگرت کوکی‌ها رو غیرفعال یا حذف کنی.</p>
            </div>

            <div class="privacy-section">
                <h4>دسترسی، ویرایش یا حذف اطلاعات</h4>
                <p>هر وقت بخوای، می‌تونی اطلاعات حساب کاربریت رو ببینی، ویرایش کنی یا حتی حذفشون کنی. ما همیشه کنار تو هستیم
                    تا کمکت کنیم!</p>
            </div>

            <div class="privacy-section">
                <h4>تماس با توکاشاپ</h4>
                <ul class="privacy-contact">
                    <li><strong>📱 اینستاگرام:</strong> <a href="https://www.instagram.com/toukashop.ir">@toukashop.ir</a>
                    </li>
                    <li><strong>📞 تلفن پشتیبانی:</strong> 0905-362-1387</li>
                    <li><strong>📞 تلفن پشتیبانی:</strong> 0992-080-5054</li>
                    <li><strong>📧 ایمیل:</strong> <a href="mailto:support@toukashop.ir">support@toukashop.ir</a></li>
                </ul>
            </div>

            <div class="privacy-alert" role="alert">
                ما تو توکاشاپ فقط یه فروشگاه نیستیم؛ یه خانواده‌ایم که عاشق حیوانات خانگیه. <br>
                خرید از توکاشاپ یعنی یه قدم برای خوشحال‌تر کردن دوستای پشمالوی تو! 💕
            </div>
        </div>
    </main>
@endsection
