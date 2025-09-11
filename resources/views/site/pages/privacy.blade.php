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

        .privacy-container {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin: 2rem auto;
            max-width: 900px;
        }

        .privacy-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.8rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }

        .privacy-title::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--pink), var(--purple));
            margin: 1rem auto;
            border-radius: 2px;
        }

        .privacy-intro {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            background-color: var(--cream);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid var(--purple);
            margin-bottom: 2rem;
        }

        .privacy-section {
            margin-bottom: 2.5rem;
        }

        .privacy-section h4 {
            font-size: 1.5rem;
            color: var(--purple);
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px dashed var(--light-purple);
            position: relative;
        }

        .privacy-section h4::before {
            content: "🌸";
            margin-left: 0.5rem;
        }

        .privacy-list {
            background-color: var(--cream);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .list-group-item {
            background-color: transparent;
            border-color: rgba(179, 153, 212, 0.2);
            padding: 0.8rem 1.2rem;
            position: relative;
            padding-right: 2rem;
        }

        .list-group-item::before {
            content: "•";
            color: var(--purple);
            font-size: 1.5rem;
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .list-unstyled li {
            padding: 0.5rem 0;
            position: relative;
            padding-right: 2rem;
        }

        .list-unstyled li::before {
            content: "✓";
            color: var(--purple);
            font-weight: bold;
            position: absolute;
            right: 0;
        }

        .privacy-contact {
            background: linear-gradient(135deg, var(--light-pink), var(--light-purple));
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
        }

        .privacy-contact li {
            margin-bottom: 0.8rem;
        }

        .privacy-contact a {
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s;
        }

        .privacy-contact a:hover {
            color: var(--purple);
            text-decoration: underline;
        }

        .privacy-alert {
            background-color: var(--cream);
            border: 1px solid var(--light-purple);
            border-left: 4px solid var(--pink);
            border-radius: 15px;
            padding: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.7;
            text-align: center;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
        }

        .privacy-alert::after {
            content: "💖";
            position: absolute;
            font-size: 5rem;
            opacity: 0.1;
            bottom: -1rem;
            left: -1rem;
            z-index: 0;
        }

        hr {
            border: none;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--light-purple), transparent);
            margin: 2rem 0;
        }

        @media (max-width: 768px) {
            .privacy-container {
                padding: 1.5rem;
            }

            .privacy-title {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('content')
    <main class="py-5" style="background-color: var(--cream); margin-top: 128px">
        <div class="privacy-container">
            <h1 class="privacy-title">حریم خصوصی در ونل</h1>

            <p class="privacy-intro">سلام دوست خوب ونلی! 🌸 ما در ونل، حفظ اطلاعات شخصی و حریم خصوصی شما رو یک مسئولیت
                مهم و جدی
                می‌دونیم. این صفحه برای اینه که شفاف و ساده برات توضیح بدیم چه اطلاعاتی از شما دریافت می‌کنیم، چطور ازش
                استفاده می‌کنیم و چه کارهایی برای حفظ امنیتش انجام می‌دیم.</p>

            <hr>

            <div class="privacy-section">
                <h4>چه اطلاعاتی از شما جمع‌آوری می‌کنیم؟</h4>
                <ul class="list-group list-group-flush privacy-list">
                    <li class="list-group-item">نام و نام خانوادگی</li>
                    <li class="list-group-item">شماره موبایل</li>
                    <li class="list-group-item">آدرس ایمیل</li>
                    <li class="list-group-item">آدرس ارسال کالا</li>
                    <li class="list-group-item">اطلاعات مربوط به سفارش‌ها</li>
                    <li class="list-group-item">اطلاعات فنی مرورگر، آی‌پی و کوکی‌ها</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h4>چرا این اطلاعات رو جمع می‌کنیم؟</h4>
                <ul class="list-unstyled privacy-list">
                    <li>سفارشت رو دقیق و سریع پردازش کنیم</li>
                    <li>تجربه خریدت رو بهتر کنیم</li>
                    <li>پیشنهادهای ویژه و تخفیف‌دار برات بفرستیم (اگه خودت بخوای)</li>
                    <li>از بروز مشکل یا سوء‌استفاده جلوگیری کنیم</li>
                </ul>
            </div>

            <div class="privacy-section">
                <h4>اطلاعات شما پیش ما امنه ❤️</h4>
                <p>ما از جدیدترین روش‌های امنیتی استفاده می‌کنیم تا اطلاعاتت محفوظ بمونه و به هیچ عنوان بدون رضایت شما،
                    اطلاعاتتون رو در اختیار شخص یا شرکت دیگه‌ای نمی‌ذاریم (مگر در شرایطی که قانون مجبورمون کنه).</p>
            </div>

            <div class="privacy-section">
                <h4>کوکی‌ها چی هستن و چرا استفاده می‌شن؟</h4>
                <p>کوکی‌ها فایل‌های کوچیکی هستن که روی مرورگرت ذخیره می‌شن و کمک می‌کنن سایت سریع‌تر و شخصی‌تر برات
                    بارگذاری شه.
                    مثلا اینکه تو کدوم شهر هستی یا چه مدل کفش‌هایی بیشتر دوست داری. اگه نخواستی، همیشه می‌تونی از
                    تنظیمات
                    مرورگرت پاکشون کنی.</p>
            </div>

            <div class="privacy-section">
                <h4>دسترسی، ویرایش یا حذف اطلاعات</h4>
                <p>هر زمانی که بخوای می‌تونی اطلاعات حساب کاربریت رو ببینی، ویرایش کنی یا حذفش کنی. ما هم همیشه
                    آماده‌ایم کمکت
                    کنیم.</p>
            </div>

            <div class="privacy-section">
                <h4>تماس با ما</h4>
                <ul class="privacy-contact">
                    <li><strong>📱 اینستاگرام:</strong> <a href="instagram://user?username=vanell.ir">@vanell.ir</a>
                    </li>
                    <li><strong>📞 تلفن پشتیبانی:</strong>09053621387</li>
                    <li><strong>📞 تلفن پشتیبانی:</strong>09920805054</li>
                </ul>
            </div>

            <div class="privacy-alert" role="alert">
                ما خوشحالیم که به ونل اعتماد کردی.<br>
                خریدت فقط یه کفش نیست؛ قدمی به سمت زیبایی، اعتماد به نفس و حال خوبه 💖
            </div>
        </div>
    </main>
@endsection
