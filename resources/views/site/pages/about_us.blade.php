@extends('layout.app')

@section('seo')
    <x-seo::seo-meta-display :model="$page" />
@endsection


@section('styles')
    <style>
        .about-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .about-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 60px;
        }

        .about-image {
            flex: 1;
            min-width: 300px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .about-image:hover img {
            transform: scale(1.05);
        }

        .about-text {
            flex: 1;
            min-width: 300px;
        }

        .about-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .feature-description {
            color: #666;
            line-height: 1.7;
        }

        .team-section {
            margin-top: 80px;
        }

        .team-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .team-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .team-member {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .member-image {
            height: 250px;
            overflow: hidden;
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .team-member:hover .member-image img {
            transform: scale(1.1);
        }

        .member-info {
            padding: 25px;
        }

        .member-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .member-role {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .member-description {
            color: #666;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transform: translateY(-3px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .section-title {
                font-size: 2.2rem;
            }

            .about-content {
                flex-direction: column;
            }

            .features-container,
            .team-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mt-128"></div>
    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge animate__animated animate__pulse">درباره ما</span>
                <h2 class="section-title animate__animated animate__fadeInDown">توکا پت شاپ، خانه امن حیوانات خانگی شما</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    بیش از یک دهه تجربه در زمینه ارائه بهترین محصولات و خدمات برای حیوانات خانگی
                </p>
            </div>

            <div class="about-content">
                <div class="about-image animate__animated animate__fadeInRight">
                    <img src="{{ asset('site/images/about-us.jpeg') }}" alt="توکا پت شاپ">
                </div>
                <div class="about-text animate__animated animate__fadeInLeft">
                    <p class="about-description">
                        توکا پت‌شاپ از سال ۱۴۰۱ در زمینه تأمین و عرضه محصولات تخصصی حیوانات خانگی فعالیت دارد. هدف ما ایجاد
                        محیطی مطمئن و قابل اعتماد برای دوستداران حیوانات است تا بتوانند نیازهای پت‌های خود را با آرامش خاطر
                        تأمین کنند.
                    </p>
                    <p class="about-description">
                        در کنار عرضه محصولات، تیم توکا پت‌شاپ همواره بر اصل علمی بودن و سلامت محور بودن خدمات تأکید دارد. به
                        همین دلیل، مشاوره‌های ارائه شده توسط دامپزشکان با تجربه انجام شده و کاربران می‌توانند با اطمینان
                        پرسش‌های خود را مطرح کنند.
                    </p>
                    <p class="about-description">
                        ما بر این باوریم که حیوانات خانگی تنها موجوداتی برای نگهداری نیستند، بلکه همراهانی ارزشمند در زندگی
                        انسان‌ها به شمار می‌آیند. از این رو، رسالت توکا پت‌شاپ تنها فروش محصول نیست؛ بلکه ارتقای فرهنگ
                        نگهداری صحیح، افزایش آگاهی صاحبان حیوانات و فراهم‌کردن شرایطی بهتر برای سلامت و شادابی پت‌ها است.
                    </p>
                </div>
            </div>

            <div class="features-container">
                <div class="feature-card animate__animated animate__fadeInUp">
                    <div class="feature-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h3 class="feature-title">مراقبت با عشق</h3>
                    <p class="feature-description">همه حیوانات سزاوار مراقبت و عشق هستند و ما این باور را در تمام خدمات خود
                        پیاده می‌کنیم.</p>
                </div>

                <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="feature-title">کیفیت تضمینی</h3>
                    <p class="feature-description">همه محصولات ما از برندهای معتبر جهانی بوده و دارای گارانتی کیفیت هستند.
                    </p>
                </div>

                <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3 class="feature-title">تحویل سریع</h3>
                    <p class="feature-description">سفارشات شما در سریع‌ترین زمان ممکن و با بسته‌بندی مناسب تحویل داده
                        می‌شود.</p>
                </div>

                <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h3 class="feature-title">پشتیبانی ۲۴/۷</h3>
                    <p class="feature-description">تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات و حل مشکلات شما می‌باشد.
                    </p>
                </div>
            </div>

            <div class="team-section">
                <div class="team-header">
                    <h2 class="section-title animate__animated animate__fadeInDown">تیم متخصص ما</h2>
                    <p class="section-subtitle animate__animated animate__fadeInUp">
                        افرادی که با عشق و تخصص خود توکا پت شاپ را شکل داده‌اند
                    </p>
                </div>

                <div class="team-container">
                    <div class="team-member animate__animated animate__fadeInLeft">
                        <div class="member-image">
                            <img src="{{ asset('site/images/users/90.png') }}" alt="دکتر مریم رضایی">
                        </div>
                        <div class="member-info">
                            <h3 class="member-name">دکتر مریم رضایی</h3>
                            <p class="member-role">دامپزشک ارشد</p>
                            <p class="member-description">دکتر رضایی با بیش از ۱۵ سال سابقه در زمینه دامپزشکی، تخصص ویژه‌ای
                                در زمینه حیوانات خانگی دارد.</p>
                            <div class="social-links">
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="team-member animate__animated animate__fadeInUp">
                        <div class="member-image">
                            <img src="{{ asset('site/images/users/5.png') }}" alt="علی محمدی">
                        </div>
                        <div class="member-info">
                            <h3 class="member-name">علی محمدی</h3>
                            <p class="member-role">متخصص تغذیه حیوانات</p>
                            <p class="member-description">علی محمدی با تحصیلات در زمینه تغذیه دام و طیور، مشاوره تخصصی در
                                زمینه رژیم غذایی حیوانات ارائه می‌دهد.</p>
                            <div class="social-links">
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="team-member animate__animated animate__fadeInRight">
                        <div class="member-image">
                            <img src="{{ asset('site/images/users/80.png') }}" alt="سارا حسینی">
                        </div>
                        <div class="member-info">
                            <h3 class="member-name">سارا حسینی</h3>
                            <p class="member-role">مربی حیوانات خانگی</p>
                            <p class="member-description">سارا با بیش از ۱۰ سال تجربه در زمینه تربیت حیوانات، به صاحبان
                                حیوانات کمک می‌کند رابطه بهتری با حیوانات خود داشته باشند.</p>
                            <div class="social-links">
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate__animated');

            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>
@endsection
