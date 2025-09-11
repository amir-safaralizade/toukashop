<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('seo')
    <title>@yield('title', 'توکا پت | فروشگاه آنلاین لوازم حیوانات شما')</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.rtl.min.css') }}">
    <!-- Font Awesome -->
    <script src="{{ asset('site/js/all.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/style.css') . '?v=' . time() }}">
    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="/favicons/site.webmanifest" />
    @yield('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{route('page.home')}}">
                <img src="{{ asset('site/logos/ll.png') }}" alt="Touka Pet Logo">
                توکا پت
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">خانه</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">محصولات</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">خدمات</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">وبلاگ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">درباره ما</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">تماس با ما</a></li>
                </ul>
                <div class="d-flex align-items-center me-3">
                    <a href="#" class="btn btn-sm btn-outline-dark ms-3"><i class="bi bi-search"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-dark ms-3"><i class="bi bi-heart"></i></a>
                    <a href="{{route('cart.mycart')}}" class="btn btn-sm btn-outline-dark ms-3"><i class="bi bi-cart3"></i></a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-logo">توکا پت</a>
                    <p class="mb-4">ما در توکا پت با عشق به حیوانات و تعهد به کیفیت، بهترین محصولات را برای حیوانات
                        خانگی شما ارائه می‌دهیم.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-telegram"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>لینک‌های سریع</h5>
                        <ul>
                            <li><a href="#">خانه</a></li>
                            <li><a href="#">محصولات</a></li>
                            <li><a href="#">خدمات</a></li>
                            <li><a href="#">وبلاگ</a></li>
                            <li><a href="#">درباره ما</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>دسته‌بندی‌ها</h5>
                        <ul>
                            <li><a href="#">سگ‌ها</a></li>
                            <li><a href="#">گربه‌ها</a></li>
                            <li><a href="#">پرندگان</a></li>
                            <li><a href="#">آبزیان</a></li>
                            <li><a href="#">جوندگان</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="footer-links">
                        <h5>تماس با ما</h5>
                        <ul>
                            <li><i class="bi bi-geo-alt-fill me-2"></i> تهران، خیابان ولیعصر، پلاک ۱۲۳۴</li>
                            <li><i class="bi bi-telephone-fill me-2"></i> ۰۲۱-۱۲۳۴۵۶۷۸</li>
                            <li><i class="bi bi-envelope-fill me-2"></i> info@toka-pet.ir</li>
                            <li><i class="bi bi-clock-fill me-2"></i> هر روز از ۹ صبح تا ۹ شب</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">© ۲۰۲۳ توکا پت. تمام حقوق محفوظ است.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">طراحی شده با <i class="bi bi-heart-fill text-danger"></i> برای حیوانات
                        دوست‌داشتنی</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- اسکریپت های Bootstrap -->
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('site/js/swiper-bundle.min.js') }}"></script>

    @if (session('success'))
        < script>
            Swal.fire({
            icon: 'success',
            title: 'موفقیت',
            text: '{{ session('success') }}'
            });
            </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'خطا',
                text: '{{ session('warning') }}'
            });
        </script>
    @endif

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate__animated');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animation = entry.target.getAttribute('data-animation');
                        entry.target.classList.add('animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>


    @yield('scripts')
</body>

</html>
