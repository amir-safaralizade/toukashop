@extends('layout.app')

@section('styles')
    <style>
        .articles-section {
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

        .articles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .article-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .article-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .article-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            text-decoration: none;
        }

        .article-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .article-card:hover .article-image img {
            transform: scale(1.1);
        }

        .article-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .article-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }

        .article-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark-color);
            line-height: 1.4;
        }

        .article-excerpt {
            color: #666;
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.7;
            flex-grow: 1;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #eee;
            position: relative;
            z-index: 2;
        }

        .article-date {
            color: #888;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .article-date i {
            margin-left: 5px;
        }

        .article-read-more {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 3;
            /* بالاتر از لینک کلی کارت */
        }

        .article-read-more:hover {
            color: var(--secondary-color);
        }

        .article-read-more i {
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        .article-read-more:hover i {
            transform: translateX(-5px);
        }

        .view-all-btn {
            text-align: center;
            margin-top: 50px;
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
            .articles-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }

            .section-title {
                font-size: 2.2rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mt-128"></div>
    <!-- سکشن مقالات -->
    <section class="articles-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge animate__animated animate__pulse animate__infinite">مطالب آموزشی</span>
                <h2 class="section-title animate__animated animate__fadeInDown">مقالات تخصصی توکا پت با برچسب :
                    {{ $tag->name }}</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    جدیدترین مطالب آموزشی و تخصصی در زمینه نگهداری، تغذیه و سلامت حیوانات خانگی
                </p>
            </div>

            <div class="articles-container">
                @foreach ($posts as $post)
                    <div class="article-card animate__animated animate__fadeInLeft">
                        <a href="{{ route('posts.show', $post->slug) }}" class="article-link"
                            aria-label="{{ $post->title }}"></a>
                        <div class="article-image">
                            <img src="{{ $post->firstMedia('main_image')?->full_url }}" alt="{{ $post->title }}">
                            <span class="article-badge">{{ $post->category->name }}</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">{{ $post->title }}</h3>
                            <p class="article-excerpt">
                                {{ $post->summary }}
                            </p>
                            <div class="article-meta">
                                <span class="article-date"><i class="bi bi-calendar"></i>
                                    {{ jdate($post->created_at)->format('Y.m.d') }}</span>
                                <a href="{{ route('posts.show', $post->slug) }}" class="article-read-more">
                                    مطالعه مقاله <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // افزودن انیمیشن هنگام اسکرول
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.article-card');

            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>
@endsection
