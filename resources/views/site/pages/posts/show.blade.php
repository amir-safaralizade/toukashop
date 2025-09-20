@extends('layout.app')

@section('styles')
    <style>
        .article-header {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(78, 205, 196, 0.05) 100%);
            padding: 80px 0 60px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .article-header::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(78, 205, 196, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .article-header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255, 107, 107, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .article-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .article-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            color: #666;
            font-size: 0.95rem;
        }

        .meta-item i {
            margin-left: 5px;
            color: var(--primary-color);
        }

        .article-hero-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            margin: 40px 0;
        }

        .article-hero-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .article-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 80px;
        }

        .article-body {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            margin-bottom: 50px;
        }

        .intro-text {
            font-size: 1.2rem;
            color: #444;
            margin-bottom: 40px;
            padding: 20px;
            border-right: 4px solid var(--secondary-color);
            background: rgba(78, 205, 196, 0.05);
            border-radius: 10px;
            line-height: 1.9;
        }

        .article-section {
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary-color);
            display: inline-block;
        }

        .tip-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border-right: 5px solid var(--secondary-color);
            transition: all 0.3s ease;
        }

        .tip-card:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .tip-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .tip-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .article-image {
            border-radius: 15px;
            overflow: hidden;
            margin: 30px 0;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .article-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: all 0.5s ease;
        }

        .article-image:hover img {
            transform: scale(1.05);
        }

        .image-caption {
            text-align: center;
            font-style: italic;
            color: #666;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .conclusion {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(78, 205, 196, 0.05) 100%);
            border-radius: 15px;
            padding: 40px;
            margin: 50px 0;
            border-right: 5px solid var(--primary-color);
        }

        .conclusion-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
        }

        .article-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .tags {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            background: rgba(78, 205, 196, 0.1);
            color: var(--secondary-color);
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .social-share {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            color: #555;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-5px);
        }

        .related-articles {
            padding: 80px 0;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .related-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 50px;
            text-align: center;
            position: relative;
            display: inline-block;
            right: 50%;
            transform: translateX(50%);
        }

        .related-title::after {
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

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .article-title {
                font-size: 2.2rem;
            }

            .article-body {
                padding: 30px;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .article-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mt-128"></div>
    <!-- هدر مقاله -->
    <header class="article-header">
        <div class="container">
            <span class="article-badge animate__animated animate__fadeIn">{{ $post->category->name }}</span>
            <h1 class="article-title animate__animated animate__fadeInDown">{{ $post->title }}</h1>

            <div class="article-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar"></i>
                    <span>{{ jdate($post->created_at)->format('Y.m.d') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>زمان مطالعه: {{ $post->estimateReadingMinutes() }} دقیقه</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-person"></i>
                    <span>نویسنده: دکتر سید عبدالعلی هاشمی نصب</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-eye"></i>
                    <span>{{ $post->visitCount() + 1500 }} بازدید</span>
                </div>
            </div>

            <div class="article-hero-image animate__animated animate__fadeInUp">
                <img src="{{ $post->firstMedia('main_image')?->full_url }}" alt="{{ $post->title }}">
            </div>
        </div>
    </header>

    <!-- محتوای مقاله -->
    <main class="article-content">
        <div class="article-body">
            {!! $post->content !!}

            <div class="article-footer">
                <div class="tags">
                    <span class="tag">گربه</span>
                    <span class="tag">تغذیه</span>
                    <span class="tag">سلامت حیوانات</span>
                    <span class="tag">نگهداری گربه</span>
                </div>

                <div class="social-share">
                    <span>اشتراک گذاری:</span>

                    {{-- Telegram --}}
                    <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                        class="social-btn" target="_blank" rel="noopener">
                        <i class="bi bi-telegram"></i>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}"
                        class="social-btn" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp"></i>
                    </a>

                    {{-- Copy Link (با JS لینک کپی میشه) --}}
                    <a href="javascript:void(0)" onclick="copyPostLink()" class="social-btn">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- مقالات مرتبط -->
    <section class="related-articles">
        <div class="container">
            <h2 class="related-title">مقالات مرتبط</h2>

            <div class="articles-container">
                <!-- مقالات مرتبط اینجا نمایش داده می‌شوند -->
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        function copyPostLink() {
            navigator.clipboard.writeText("{{ request()->fullUrl() }}")
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'لینک کپی شد!',
                        text: 'می‌تونی الان به راحتی لینک مقاله رو به اشتراک بذاری.',
                        confirmButtonText: 'باشه',
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: 'مشکلی در کپی لینک پیش اومد.',
                        confirmButtonText: 'باشه',
                    });
                });
        }
    </script>
@endsection
