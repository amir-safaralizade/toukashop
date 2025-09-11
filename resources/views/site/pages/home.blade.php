@extends('layout.app')

@section('content')
    <section class="vanell-luxury-hero">
        <div class="vanell-crystal-pattern"></div>

        <div class="vanell-glowing-dots">
            <div class="vanell-dot"></div>
            <div class="vanell-dot"></div>
            <div class="vanell-dot"></div>
        </div>

        <div class="vanell-glow-effect vanell-glow-1"></div>
        <div class="vanell-glow-effect vanell-glow-2"></div>

        <div class="vanell-hero-content">
            <div class="vanell-hero-text">
                <h1 class="vanell-main-title">پاهات لیاقت بهترینا رو داره</h1>
                <p class="vanell-sub-title">در فروشگاه ونل، هر جفت کفش یک اثر هنری منحصر به فرده که با دقت و ظرافت طراحی
                    شده تا استایل تو رو کامل کنه.</p>

                <div class="vanell-cta-container">
                    <a href="{{ route('products.index') }}" class="vanell-main-cta">مشاهده محصولات</a>
                    <a href="{{ route('products.index') }}" class="vanell-secondary-cta">مجموعه جدید</a>
                </div>
            </div>

            <div class="vanell-shoe-showcase">
                <div class="vanell-shoe vanell-shoe-1 vanell-floating" style="--initial-rotate: -15deg;">
                    <img src="{{ asset('site/images/pic6.jpg') }}" alt="کفش اسپرت دخترانه ونل" loading="lazy">
                </div>
                <div class="vanell-shoe vanell-shoe-2 vanell-floating vanell-float-delay-1"
                    style="--initial-rotate: 10deg;">
                    <img src="{{ asset('site/images/pic7.jpg') }}" alt="کفش مجلسی دخترانه ونل" loading="lazy">
                </div>
                <div class="vanell-shoe vanell-shoe-3 vanell-floating vanell-float-delay-2" style="--initial-rotate: 5deg;">
                    <img src="{{ asset('site/images/pic8.jpg') }}" alt="کفش روزمره دخترانه ونل" loading="lazy">
                </div>
            </div>
        </div>
    </section>


    <section class="py-5 my-5" id="products">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">محصولات پرفروش</h2>
                <p class="lead fade-in delay-1">انتخاب نسل جوان</p>
            </div>
            <div class="row">
                @foreach ($data->products as $index => $product)
                    <div class="col-lg-3 col-md-6 fade-in {{ $loop->first ? '' : 'delay-' . $loop->index }}">
                        <div class="product-card">
                            <div class="product-img">
                                <span class="product-badge">جدید</span>
                                <img alt="کفش اسپرت" src="{{ $product->firstMedia('main_image')?->full_url }}"
                                    loading="lazy" />
                                <div class="product-actions">
                                    <a class="product-action-btn" href="#"><i class="bi bi-heart"></i></a>
                                    <a class="product-action-btn" href="#"><i class="bi bi-cart"></i></a>
                                    <a class="product-action-btn" href="{{ route('products.show', $product->slug) }}"><i
                                            class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <p class="product-price">{{ number_format($product->price) . ' تومان' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5 fade-in delay-4">
                <a class="btn btn-vanell" href="#">مشاهده همه محصولات</a>
            </div>
        </div>
    </section>

    <section class="flash-sale">
        <div class="container">
            <div class="sale-header fade-in">
                <span class="sale-tag">تخفیف‌های ویژه</span>
                <h2 class="section-title text-white">حراج پایان فصل ونل</h2>
                <p class="lead">
                    فقط تا پایان هفته فرصت دارید با بهترین قیمت خرید کنید!
                </p>
                <div class="sale-countdown fade-in delay-1">
                    <div class="countdown-box">
                        <div class="countdown-value" id="days">۰۲</div>
                        <div class="countdown-label">روز</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value" id="hours">۱۲</div>
                        <div class="countdown-label">ساعت</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value" id="minutes">۴۵</div>
                        <div class="countdown-label">دقیقه</div>
                    </div>
                    <div class="countdown-box">
                        <div class="countdown-value" id="seconds">۳۰</div>
                        <div class="countdown-label">ثانیه</div>
                    </div>
                </div>
            </div>

            <div class="sale-products position-relative">
                <div class="swiper sale-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($data->special_products as $product)
                            <div class="swiper-slide fade-in">
                                <div class="sale-product-card">
                                    <div class="sale-product-badge">12٪ تخفیف</div>
                                    <div class="sale-product-img">
                                        <img alt="کفش ورزشی" src="{{ $product->firstMedia('main_image')?->full_url }}"
                                            loading="lazy" />
                                    </div>
                                    <div class="sale-product-info">
                                        <h3 class="sale-product-title">{{ $product->name }}</h3>
                                        <div class="sale-product-price">
                                            <span
                                                class="sale-product-oldprice">{{ number_format(ceil($product->price * 1.12)) }}
                                                تومان</span>
                                            <span class="sale-product-newprice">{{ number_format($product->price) }}
                                                تومان</span>
                                        </div>
                                        <a class="sale-btn" href="{{ route('products.show', $product->slug) }}">خرید سریع</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- دکمه‌های هدایت -->
                    <div class="sale-arrow sale-prev swiper-button-prev"><i class="bi bi-chevron-right"></i></div>
                    <div class="sale-arrow sale-next swiper-button-next"><i class="bi bi-chevron-left"></i></div>
                </div>
            </div>
        </div>
    </section>


    <section class="categories-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">دسته‌بندی‌ها</h2>
                <p class="lead fade-in delay-1">
                    محصولات ونل را بر اساس نیاز خود جستجو کنید
                </p>
            </div>
            <div class="category-grid">
                <div class="category-card fade-in">
                    <img alt="کفش‌های ورزشی" class="category-img" src="{{ asset('site/images/pic9.jpg') }}"
                        loading="lazy" />
                    <div class="category-content">
                        <h3 class="category-title">کفش‌های ورزشی</h3>
                        <a class="category-link" href="{{ route('products.index') . '?category=1' }}">
                            مشاهده محصولات
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="category-card fade-in delay-1">
                    <img alt="کفش های اسپرت" class="category-img" src="{{ asset('site/images/pic5.jpg') }}"
                        loading="lazy" />
                    <div class="category-content">
                        <h3 class="category-title">کفش‌های روزمره</h3>
                        <a class="category-link" href="{{ route('products.index') . '?category=2' }}">
                            مشاهده محصولات
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="category-card fade-in delay-2">
                    <img alt="کفش‌های کلاسیک" class="category-img" src="{{ asset('site/images/pic10.jpg') }}"
                        loading="lazy" />
                    <div class="category-content">
                        <h3 class="category-title">کفش‌های اسلیپر</h3>
                        <a class="category-link" href="{{ route('products.index') . '?category=3' }}">
                            مشاهده محصولات
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="category-card fade-in delay-3">
                    <img alt="کفش‌های اسکیت" class="category-img" src="{{ asset('site/images/pic11.jpg') }}"
                        loading="lazy" />
                    <div class="category-content">
                        <h3 class="category-title">کفش های فانتزی</h3>
                        <a class="category-link" href="{{ route('products.index') . '?category=4' }}">
                            مشاهده محصولات
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="collection-section py-5" id="collections">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title text-light fade-in">مجموعه‌های فصلی</h2>
                <p class="lead text-light-50 fade-in delay-1">
                    طراحی‌های ویژه برای هر فصل
                </p>
            </div>
            <div class="row">
                <div class="col-md-6 fade-in">
                    <div class="collection-card">
                        <img alt="مجموعه تابستانه" class="collection-img" src="{{ asset('site/images/pic3.jpg') }}"
                            loading="lazy" />
                        <div class="collection-overlay">
                            <h3 class="collection-title">مجموعه تابستانه</h3>
                            <p class="text-light-50 mb-4">
                                طراحی‌های سبک و خنک برای روزهای گرم
                            </p>
                            <a class="btn btn-outline-vanell" href="#">مشاهده مجموعه</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 fade-in delay-1">
                    <div class="collection-card">
                        <img alt="مجموعه زمستانه" class="collection-img" src="{{ asset('site/images/winter.jpg') }}"
                            loading="lazy" />
                        <div class="collection-overlay">
                            <h3 class="collection-title">مجموعه زمستانه</h3>
                            <p class="text-light-50 mb-4">گرم و راحت برای روزهای سرد</p>
                            <a class="btn btn-outline-vanell" href="#">مشاهده مجموعه</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="challenge-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title text-light fade-in">چالش ونل</h2>
                <p class="lead text-light-50 fade-in delay-1">
                    به چالش بکشید، برنده شوید!
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 fade-in">
                    <div class="challenge-card">
                        <div class="challenge-icon">
                            <i class="bi bi-camera"></i>
                        </div>
                        <h3>چالش عکاسی</h3>
                        <p>
                            عکس خلاقانه با کفش‌های ونل بگیرید و در اینستاگرام با هشتگ
                            #VanellChallenge منتشر کنید.
                        </p>
                        <div class="challenge-number">۱۰۰۰+ شرکت کننده</div>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-1">
                    <div class="challenge-card">
                        <div class="challenge-icon">
                            <i class="bi bi-lightning"></i>
                        </div>
                        <h3>چالش ورزشی</h3>
                        <p>
                            ویدیوی ورزش کردن با کفش‌های ونل را منتشر کنید و شانس برنده شدن
                            جایزه ویژه را داشته باشید.
                        </p>
                        <div class="challenge-number">۵۰۰+ ویدیو</div>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-2">
                    <div class="challenge-card">
                        <div class="challenge-icon">
                            <i class="bi bi-palette"></i>
                        </div>
                        <h3>چالش طراحی</h3>
                        <p>
                            طرح خلاقانه برای مدل بعدی ونل بفرستید. طرح برنده تولید خواهد شد!
                        </p>
                        <div class="challenge-number">۲۰۰+ طرح</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="video-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 fade-in">
                    <div class="video-wrapper">
                        <!-- ستون ویدیو -->
                        <div class="video-column">
                            <div class="video-container" id="video-container">
                                <!-- ویدیو اصلی -->
                                <video id="main-video" class="video-player" playsinline webkit-playsinline muted loop>
                                    <source src="{{ asset('site/videos/main_video.mp4') }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>

                                <!-- پیش‌نمایش ویدیو (پوستر) -->
                                <img id="video-poster" alt="ویدیو ونل" class="img-fluid"
                                    src="{{ asset('site/videos/main_video_poster.jpg') }}" loading="lazy" />

                                <!-- لایه overlay -->
                                <div class="video-overlay"></div>

                                <!-- دکمه پخش -->
                                <button class="video-play-btn" id="play-button" aria-label="Play video">
                                    <svg class="play-icon" viewBox="0 0 24 24">
                                        <path class="play-shape" d="M8 5v14l11-7z" />
                                        <circle class="play-circle" cx="12" cy="12" r="11" />
                                    </svg>
                                    <span class="pulse-effect"></span>
                                </button>

                                <!-- کنترل‌های ویدیو -->
                                <div class="video-controls">
                                    <div class="progress-container">
                                        <div class="progress-bar"></div>
                                        <div class="progress-handle"></div>
                                    </div>
                                    <div class="controls-bottom">
                                        <button class="control-btn volume-btn" aria-label="Volume">
                                            <i class="bi bi-volume-up"></i>
                                        </button>
                                        <div class="time-display">
                                            <span class="current-time">0:00</span> /
                                            <span class="duration">0:00</span>
                                        </div>
                                        <button class="control-btn fullscreen-btn" aria-label="Fullscreen">
                                            <i class="bi bi-fullscreen"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ستون توضیحات -->
                        <div class="content-column">
                            <h2 class="section-title">بفرمایید کفش ونل!</h2>
                            <p class="lead fade-in delay-1">
                                اینم بسته‌بندی ما😍
                            </p>
                            <div class="video-description">
                                <p>
                                    ما همه سفارش‌هارو با کلی عشق و بسته‌بندی قشنگ توی کمترین زمان ممکن به دستت
                                    می‌رسونیم! از لحظه سفارش تا تحویل در خونه، حواسمون به همه‌چی هست 💖
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const videoContainer = document.getElementById('video-container LiteSpeed Cache');
                const video = document.getElementById('main-video');
                const poster = document.getElementById('video-poster');
                const playButton = document.getElementById('play-button');
                const progressBar = document.querySelector('.progress-bar');
                const progressHandle = document.querySelector('.progress-handle');
                const progressContainer = document.querySelector('.progress-container');
                const currentTimeDisplay = document.querySelector('.current-time');
                const durationDisplay = document.querySelector('.duration');
                const volumeBtn = document.querySelector('.volume-btn');
                const fullscreenBtn = document.querySelector('.fullscreen-btn');

                let isPlaying = false;
                let isSeeking = false;

                // فرمت زمان (mm:ss)
                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
                }

                // به‌روزرسانی نوار پیشرفت
                function updateProgress() {
                    if (!isSeeking && video.duration) {
                        const progress = (video.currentTime / video.duration) * 100;
                        progressBar.style.width = `${progress}%`;
                        progressHandle.style.right = `${progress}%`;
                        currentTimeDisplay.textContent = formatTime(video.currentTime);
                    }
                }

                // تنظیم موقعیت ویدیو بر اساس کلیک روی نوار پیشرفت
                function setProgress(e) {
                    if (!video.duration) return;

                    isSeeking = true;
                    const rect = progressContainer.getBoundingClientRect();
                    const width = rect.width;
                    const clickX = e.clientX - rect.left;
                    const progress = (width - clickX) / width;
                    const newTime = progress * video.duration;

                    // متوقف کردن ویدیو قبل از جستجو
                    video.pause();

                    // تنظیم زمان جدید
                    video.currentTime = Math.max(0, Math.min(newTime, video.duration));

                    // به‌روزرسانی فوری نوار پیشرفت
                    progressBar.style.width = `${progress * 100}%`;
                    progressHandle.style.right = `${progress * 100}%`;
                    currentTimeDisplay.textContent = formatTime(newTime);

                    // پخش ویدیو پس از جستجو
                    video.play().then(() => {
                        isSeeking = false;
                    }).catch(error => {
                        console.error("Playback failed:", error);
                        isSeeking = false;
                    });
                }

                // رویدادهای ویدیو
                video.addEventListener('loadedmetadata', function() {
                    durationDisplay.textContent = formatTime(video.duration);
                });

                video.addEventListener('timeupdate', updateProgress);

                video.addEventListener('seeked', function() {
                    isSeeking = false;
                });

                video.addEventListener('play', function() {
                    isPlaying = true;
                    videoContainer.classList.add('playing');
                    playButton.innerHTML = '<i class="bi bi-pause-fill"></i>';
                });

                video.addEventListener('pause', function() {
                    isPlaying = false;
                    videoContainer.classList.remove('playing');
                    playButton.innerHTML =
                        '<svg class="play-icon" viewBox="0 0 24 24"><path class="play-shape" d="M8 5v14l11-7z"/><circle class="play-circle" cx="12" cy="12" r="11"/></svg><span class="pulse-effect"></span>';
                });

                // کنترل پخش/توقف
                function togglePlay() {
                    if (video.paused) {
                        video.style.display = 'block';
                        poster.style.display = 'none';
                        video.muted = false;
                        video.play().catch(error => console.error("Playback failed:", error));
                    } else {
                        video.pause();
                    }
                }

                playButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    togglePlay();
                });

                video.addEventListener('click', togglePlay);

                // کنترل صدا
                volumeBtn.addEventListener('click', function() {
                    video.muted = !video.muted;
                    this.innerHTML = video.muted ? '<i class="bi bi-volume-mute"></i>' :
                        '<i class="bi bi-volume-up"></i>';
                });

                // کنترل تمام‌صفحه
                fullscreenBtn.addEventListener('click', function() {
                    if (videoContainer.requestFullscreen) {
                        videoContainer.requestFullscreen();
                    } else if (videoContainer.webkitRequestFullscreen) {
                        videoContainer.webkitRequestFullscreen();
                    }
                });

                // کلیک روی نوار پیشرفت
                progressContainer.addEventListener('click', function(e) {
                    e.stopPropagation();
                    setProgress(e);
                });

                // نمایش کنترل‌ها هنگام هاور
                videoContainer.addEventListener('mouseenter', function() {
                    if (isPlaying) {
                        document.querySelector('.video-controls').style.opacity = '1';
                        document.querySelector('.video-controls').style.transform = 'translateY(0)';
                    }
                });

                videoContainer.addEventListener('mouseleave', function() {
                    if (isPlaying) {
                        document.querySelector('.video-controls').style.opacity = '0';
                        document.querySelector('.video-controls').style.transform = 'translateY(10px)';
                    }
                });
            });
        </script>
    </section>

    <section class="about-section py-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 fade-in">
                    <div class="about-img">
                        <img alt="درباره ونل" class="img-fluid" src="{{ asset('site/images/s4.jpg') }}"
                            loading="lazy" />
                    </div>
                </div>
                <div class="col-lg-6 fade-in delay-1">
                    <h2 class="section-title">درباره ونل</h2>
                    <p class="lead">هر قدم، یک داستان است</p>
                    <p>
                        ونل یک برند کفش ایرانی است که با هدف ارائه محصولات باکیفیت و
                        طراحی‌های مدرن برای نسل جوان تأسیس شده است. ما به جزئیات اهمیت
                        می‌دهیم و هر جفت کفش را با دقت و عشق می‌سازیم.
                    </p>
                    <p>
                        تیم ونل متشکل از طراحان جوان و خلاقی است که دائماً در حال نوآوری و
                        ارائه طرح‌های جدید هستند. ما به محیط زیست احترام می‌گذاریم و از
                        مواد پایدار در تولیدات خود استفاده می‌کنیم.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <div class="text-center">
                            <h3 class="text-accent">+۸</h3>
                            <p>سال تجربه</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-accent">۱۰۰۰۰+</h3>
                            <p>مشتری راضی</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-accent">۱۰۰%</h3>
                            <p>تضمین کیفیت</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="instagram-highlight">
        <div class="container">
            <!-- دکوریشن‌های جدید -->
            <div class="instagram-decoration deco-1">🌸</div>
            <div class="instagram-decoration deco-2">✨</div>
            <div class="instagram-decoration deco-3">💖</div>

            <div class="instagram-header ">
                <div class="instagram-logo">
                    <i class="bi bi-instagram"></i>
                </div>
                <h2 class="instagram-username">
                    ما را در اینستاگرام دنبال کنید <span>@vanell.ir</span>
                </h2>
            </div>

            <div class="instagram-feed">
                <!-- پست ۱ -->
                <div class="instagram-post ">
                    <img src="{{ asset('site/images/in1.jpg') }}" alt="پست اینستاگرام وانل" loading="lazy">
                    <div class="instagram-overlay">
                        <div class="instagram-stats">
                            <i class="bi bi-heart-fill"></i>
                            <span>۲۴۳۱ لایک</span>
                            <i class="bi bi-chat-fill mt-3"></i>
                            <span>۱۸۹ نظر</span>
                        </div>
                    </div>
                </div>

                <!-- پست ۲ -->
                <div class="instagram-post  delay-1">
                    <img src="{{ asset('site/images/in2.jpg') }}" alt="پست اینستاگرام وانل" loading="lazy">
                    <div class="instagram-overlay">
                        <div class="instagram-stats">
                            <i class="bi bi-heart-fill"></i>
                            <span>۳۵۶۷ لایک</span>
                            <i class="bi bi-chat-fill mt-3"></i>
                            <span>۲۴۵ نظر</span>
                        </div>
                    </div>
                </div>

                <!-- پست ۳ -->
                <div class="instagram-post  delay-2">
                    <img src="{{ asset('site/images/in3.jpg') }}" alt="پست اینستاگرام وانل" loading="lazy">
                    <div class="instagram-overlay">
                        <div class="instagram-stats">
                            <i class="bi bi-heart-fill"></i>
                            <span>۱۸۹۲ لایک</span>
                            <i class="bi bi-chat-fill mt-3"></i>
                            <span>۱۳۴ نظر</span>
                        </div>
                    </div>
                </div>

                <!-- پست ۴ -->
                <div class="instagram-post  delay-3">
                    <img src="{{ asset('site/images/in4.jpg') }}" alt="پست اینستاگرام وانل" loading="lazy">
                    <div class="instagram-overlay">
                        <div class="instagram-stats">
                            <i class="bi bi-heart-fill"></i>
                            <span>۴۲۱۰ لایک</span>
                            <i class="bi bi-chat-fill mt-3"></i>
                            <span>۳۲۱ نظر</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="instagram-cta  delay-4">
                <a class="instagram-handle" href="https://instagram.com/vanell.official" target="_blank">
                    <i class="bi bi-instagram"></i> @vanell.ir
                </a>
                <p class="lead">
                    ما را دنبال کنید و از آخرین تخفیف‌ها، مسابقات و محصولات جدید با خبر شوید!
                    <br>
                    هر روز کلی محتوای کیوت و جذاب منتظر شماست! 💕
                </p>
            </div>
        </div>
    </section>

    <section class="user-styles-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">استایل‌های کاربران</h2>
                <p class="lead fade-in delay-1">ونل از نگاه شما</p>
            </div>

            <div class="swiper user-style-swiper position-relative">

                <!-- Wrapper for slides -->
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="style-card">
                            <img alt="استایل کاربر" class="img-fluid" src="/site/images/s1.jpg" loading="lazy" />
                            <div class="style-user">
                                <img alt="کاربر" src="/template/images/avatar/nazanin-m.jpg" loading="lazy" />
                                <div>
                                    <div class="style-username">نازنین محمدی</div>
                                    <div class="style-location">تهران</div>
                                </div>
                                <div class="ms-auto style-likes">
                                    <i class="bi bi-heart-fill"></i> ۲۴۳
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="style-card">
                            <img alt="استایل کاربر" class="img-fluid" src="/site/images/s2.jpg" loading="lazy" />
                            <div class="style-user">
                                <img alt="کاربر" src="/template/images/avatar/a-sm.jpg" loading="lazy" />
                                <div>
                                    <div class="style-username">امیرحسین رضایی</div>
                                    <div class="style-location">اصفهان</div>
                                </div>
                                <div class="ms-auto style-likes">
                                    <i class="bi bi-heart-fill"></i> ۱۸۷
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="style-card">
                            <img alt="استایل کاربر" class="img-fluid" src="/site/images/s3.jpg" loading="lazy" />
                            <div class="style-user">
                                <img alt="کاربر" src="/template/images/avatar/zahra-kh.jpg" loading="lazy" />
                                <div>
                                    <div class="style-username">زهرا خادم</div>
                                    <div class="style-location">مشهد</div>
                                </div>
                                <div class="ms-auto style-likes">
                                    <i class="bi bi-heart-fill"></i> ۳۲۱
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="style-card">
                            <img alt="استایل کاربر" class="img-fluid" src="/site/images/s4.jpg" loading="lazy" />
                            <div class="style-user">
                                <img alt="کاربر" src="/template/images/avatar/sara-h.jpg" loading="lazy" />
                                <div>
                                    <div class="style-username">سارا حسینی</div>
                                    <div class="style-location">مشهد</div>
                                </div>
                                <div class="ms-auto style-likes">
                                    <i class="bi bi-heart-fill"></i> ۲۶۰
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Navigation buttons -->
                <div class="slider-nav slider-prev swiper-button-prev">
                    <i class="bi bi-chevron-right"></i>
                </div>
                <div class="slider-nav slider-next swiper-button-next">
                    <i class="bi bi-chevron-left"></i>
                </div>

            </div>
        </div>
    </section>

    <section class="newsletter-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center fade-in">
                    <h2 class="mb-4">به خانواده ونل بپیوندید</h2>
                    <p class="mb-5">
                        برای دریافت جدیدترین محصولات و تخفیف‌های ویژه ایمیل خود را وارد
                        کنید
                    </p>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-8">
                            <input class="form-control newsletter-input" placeholder="آدرس ایمیل شما" type="email" />
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-vanell w-100" style="background: var(--dark-bg)">
                                عضویت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    let productId = this.dataset.id;

                    fetch("{{ route('cart.addToCartAjax') }}", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'محصول افزوده شد!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // ✅ فقط این کافی‌ست چون تابع کلی داریم
                                updateCartCount();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا',
                                    text: data.message || 'افزودن محصول ناموفق بود.',
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا',
                                text: 'خطایی در افزودن به سبد رخ داد.',
                            });
                            console.error(err);
                        });
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper('.sale-swiper', {
                loop: true, // ✅ این خط رو اضافه کن
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.sale-next',
                    prevEl: '.sale-prev',
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper('.user-style-swiper', {
                loop: true,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.slider-next',
                    prevEl: '.slider-prev',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    }
                }
            });
        });
    </script>
@endsection
