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

        .size-guide-container {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin: 2rem auto;
            max-width: 900px;
        }

        .size-guide-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.8rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }

        .size-guide-title::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--pink), var(--purple));
            margin: 1rem auto;
            border-radius: 2px;
        }

        .size-guide-intro {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            background-color: var(--cream);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid var(--purple);
            margin-bottom: 2rem;
        }

        .size-guide-section {
            margin-bottom: 2.5rem;
        }

        .size-guide-section h4 {
            font-size: 1.5rem;
            color: var(--purple);
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px dashed var(--light-purple);
            position: relative;
        }

        .size-guide-section h4::before {
            content: "👟";
            margin-left: 0.5rem;
        }

        ol.size-guide-steps, ul.size-guide-tips {
            background-color: var(--cream);
            border-radius: 10px;
            padding: 1.5rem 1.5rem 1.5rem 2.5rem;
            margin: 1.5rem 0;
        }

        ol.size-guide-steps li, ul.size-guide-tips li {
            padding: 0.5rem 0;
            position: relative;
            line-height: 1.7;
        }

        ol.size-guide-steps li::before {
            position: absolute;
            right: -2rem;
            font-weight: bold;
            color: var(--purple);
        }

        .size-guide-alert {
            background-color: var(--cream);
            border: 1px solid var(--light-purple);
            border-left: 4px solid var(--pink);
            border-radius: 15px;
            padding: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.7;
            margin: 1.5rem 0;
            position: relative;
            overflow: hidden;
        }

        .size-guide-alert::before {
            content: "💡";
            position: absolute;
            font-size: 2rem;
            opacity: 0.2;
            top: 0.5rem;
            left: 0.5rem;
        }

        .size-guide-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
        }

        .size-guide-table th {
            background: linear-gradient(to right, var(--pink), var(--purple));
            color: var(--white);
            padding: 1rem;
            text-align: center;
        }

        .size-guide-table td {
            padding: 0.8rem;
            text-align: center;
            border: 1px solid var(--light-purple);
        }

        .size-guide-table tr:nth-child(even) {
            background-color: var(--cream);
        }

        .size-guide-note {
            font-size: 0.9rem;
            color: var(--text-dark);
            opacity: 0.8;
            margin-top: -1rem;
            margin-bottom: 2rem;
        }

        .size-guide-warning {
            background: linear-gradient(135deg, var(--light-pink), var(--light-purple));
            padding: 1.5rem;
            border-radius: 15px;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .size-guide-warning::before {
            content: "❓";
            position: absolute;
            font-size: 5rem;
            opacity: 0.1;
            bottom: -1rem;
            left: -1rem;
        }

        .size-guide-warning strong {
            color: var(--dark-pink);
        }

        @media (max-width: 768px) {
            .size-guide-container {
                padding: 1.5rem;
            }

            .size-guide-title {
                font-size: 2rem;
            }

            .size-guide-table {
                font-size: 0.9rem;
            }
        }
    </style>
@endsection

@section('content')
    <main class="py-5" style="background-color: var(--cream); margin-top: 128px">
        <div class="size-guide-container">
            <h1 class="size-guide-title">راهنمای انتخاب سایز کفش</h1>

            <p class="size-guide-intro">سلام ونلی عزیز! 👟💖 ما می‌دونیم که خرید کفش بدون پرو کردن، ممکنه کمی استرس‌زا باشه. اما نگران نباش! این راهنما با دقت تهیه شده تا بتونی <strong>سایز دقیق و واقعی خودت رو راحت و مطمئن پیدا کنی</strong>.</p>

            <div class="size-guide-section">
                <h4>قدم اول: طول پای خودت رو اندازه بگیر 📏</h4>
                <ol class="size-guide-steps">
                    <li>یه برگه A4 روی زمین بذار و پاتو صاف و کامل روش بذار.</li>
                    <li>دور پاتو با مداد خط بکش (با جوراب نازک یا بدون جوراب).</li>
                    <li>از نوک بلندترین انگشت تا پاشنه پا رو با خط‌کش اندازه بگیر. (به میلی‌متر)</li>
                    <li>همین کارو برای هر دو پا انجام بده و <strong>بیشترین عدد رو ملاک قرار بده</strong>.</li>
                </ol>

                <div class="size-guide-alert">
                    🧠 مثلاً اگه طول پات ۲۴.۳ سانتی‌متره، باید سایزی انتخاب کنی که مناسب ۲۴.۵ تا ۲۵ باشه.
                </div>
            </div>

            <div class="size-guide-section">
                <h4>جدول تبدیل طول پا به سایز</h4>
                <table class="size-guide-table">
                    <thead>
                    <tr>
                        <th>طول پا (cm)</th>
                        <th>سایز EU</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td>22.5</td><td>36</td></tr>
                    <tr><td>23.0</td><td>37</td></tr>
                    <tr><td>23.5</td><td>37.5</td></tr>
                    <tr><td>24.0</td><td>38</td></tr>
                    <tr><td>24.5</td><td>39</td></tr>
                    <tr><td>25.0</td><td>40</td></tr>
                    <tr><td>25.5</td><td>41</td></tr>
                    <tr><td>26.0</td><td>42</td></tr>
                    </tbody>
                </table>

                <p class="size-guide-note">👟 این جدول بر اساس کفش‌های استاندارد ونل طراحی شده. ممکنه بعضی مدل‌ها به‌دلیل قالب خاصشون، پیشنهاد خاص‌تری داشته باشن که توی توضیحات محصول می‌نویسیم.</p>
            </div>

            <div class="size-guide-section">
                <h4>نکات طلایی برای انتخاب بهتر</h4>
                <ul class="size-guide-tips">
                    <li>اگر بین دو سایز بودی، <strong>پیشنهاد می‌کنیم سایز بزرگ‌تر رو انتخاب کنی</strong>.</li>
                    <li>کفش‌های اسپرت معمولاً قالب استاندارد دارن، اما بوت‌ها و کفش‌های بندی ممکنه <strong>نسبت به فرم پا تاثیر بذارن</strong>.</li>
                    <li>اگه روی پا یا انگشت‌های کشیده داری، بهتره نیم‌سایز بزرگ‌تر برداری.</li>
                </ul>
            </div>

            <div class="size-guide-warning">
                <strong>❓ هنوز شک داری؟</strong><br>
                نگران نباش! کافیه یه پیام به پشتیبانی بدی و بگی:<br>
                <em>«طول پام ۲۴.۲ سانته، دنبال یه کفش راحت و روزمره‌ام. چی پیشنهاد می‌دین؟»</em><br>
                ما با عشق و دقت راهنماییت می‌کنیم ❤️
            </div>
        </div>
    </main>
@endsection
