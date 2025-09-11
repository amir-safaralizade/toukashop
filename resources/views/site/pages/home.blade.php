@extends('layout.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content animate__animated animate__fadeIn">
            <h1>لوازم لاکچری برای حیوانات با نمک شما</h1>
            <p>در توکا پت، بهترین و شیک‌ترین محصولات را برای حیوانات خانگی دوست‌داشتنی شما آماده کرده‌ایم. کیفیت را با ما
                تجربه کنید.</p>
            <div class="mt-4">
                <a href="#" class="btn btn-primary btn-lg">محصولات ویژه</a>
                <a href="#" class="btn btn-outline-light btn-lg">درباره ما</a>
            </div>
        </div>

        <!-- Floating pet icons -->
        <i class="bi bi-egg-fried pet-icon floating" style="top: 20%; left: 10%; animation-delay: 0.2s;"></i>
        <i class="bi bi-bone pet-icon floating" style="top: 70%; right: 15%; animation-delay: 0.5s;"></i>
        <i class="bi bi-balloon-heart pet-icon floating" style="top: 30%; right: 20%; animation-delay: 0.7s;"></i>
        <i class="bi bi-gem pet-icon floating" style="bottom: 10%; left: 20%; animation-delay: 0.3s;"></i>
    </section>

    <!-- Features Section -->
    <section class="container my-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">چرا توکا پت؟</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>کیفیت تضمینی</h4>
                    <p>تمام محصولات ما با بالاترین استانداردهای کیفیت انتخاب شده‌اند و سلامت حیوان شما را تضمین می‌کنند.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>تحویل سریع</h4>
                    <p>سفارشات شما در کمترین زمان ممکن آماده و به درب منزل شما ارسال می‌شود.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>پشتیبانی 24/7</h4>
                    <p>تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات و راهنمایی شماست.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 1 - Pet Categories -->
    <section class="creative-section">
        <div class="creative-bg" style="background-image: url('{{ asset('site/images/categoryBackgroud.jpg') }}');"></div>
        <div class="container">
            <div class="creative-content animate__animated animate__fadeIn">
                <div class="text-center mb-5">
                    <h2 class="section-title">دسته‌بندی حیوانات</h2>
                    <p class="lead">محصولات اختصاصی برای هر نوع حیوان خانگی</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-valentine2 text-primary"></i>
                            </div>
                            <h5>سگ‌ها</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-valentine2 text-primary"></i>
                            </div>
                            <h5>گربه‌ها</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-valentine2 text-primary"></i>
                            </div>
                            <h5>پرندگان</h5>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="text-center">
                            <div class="bg-light p-4 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-valentine2 text-primary"></i>
                            </div>
                            <h5>آبزیان</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">محصولات پرفروش</h2>
            <p class="lead">محصولاتی که مشتریان ما عاشقشان هستند</p>
        </div>
        <div class="row g-4">
            @foreach ($data->products as $product)
                <div class="col-lg-3 col-md-6 animate__animated animate__fadeInUp">
                    <div class="product-card">
                        <div class="product-badge">پرفروش</div>
                        <img src="{{ asset('site/images/p1.jpeg') }}" class="product-img w-100" alt="غذای گربه">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-light text-dark">{{ $product->name }}</span>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted small">{{ $product->name }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="price">{{ $product->price * 1.2 }}</span>
                                    <span class="old-price ms-2">{{ $product->price }}</span>
                                </div>
                                <a href="{{route('products.show' , $product->slug)}}" class="btn btn-sm btn-outline-primary"><i class="bi bi-cart-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="#" class="btn btn-primary btn-lg">مشاهده همه محصولات</a>
        </div>
    </section>


    <!-- Creative Section 2 - Testimonials -->
    <section class="creative-section bg-light">
        <div class="creative-bg"
            style="background-image: url('{{asset('site/images/photo20788510751.jpg')}}');"></div>
        <div class="container">
            <div class="creative-content animate__animated animate__fadeIn">
                <div class="text-center mb-5">
                    <h2 class="section-title">نظرات مشتریان</h2>
                    <p class="lead">آنچه مشتریان ما درباره توکا پت می‌گویند</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">سارا محمدی</h6>
                                    <small class="text-muted">مالک گربه</small>
                                </div>
                            </div>
                            <p>محصولات توکا پت واقعا کیفیت بالایی دارند. گربه من عاشق غذای تونایی شده و هر بار با اشتها
                                می‌خوره. ممنون از خدمات عالیتون.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/men/75.jpg" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">امیر حسینی</h6>
                                    <small class="text-muted">مالب سگ</small>
                                </div>
                            </div>
                            <p>قلاده چرمی که خریدم واقعا لاکچریه و دوام بالایی داره. تحویل سریع و بسته‌بندی شیک هم از مزایای
                                خرید از توکا پته.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">نازنین رضایی</h6>
                                    <small class="text-muted">مالک پرنده</small>
                                </div>
                            </div>
                            <p>قفس پرنده‌ای که از توکا پت خریدم طراحی فوق‌العاده‌ای داره و واقعا برای پرنده‌ام فضای مناسبی
                                ایجاد کرده. مشاوره خوبتون هم کمک بزرگی بود.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 3 - Instagram -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">اینستاگرام ما</h2>
            <p class="lead">تصاویر حیوانات با نمک مشتریان ما را دنبال کنید</p>
        </div>
        <div class="row g-3">
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1533738363-b7f9aef128ce.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1526336024174-e58f5cdd8e13.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1594149929911-78975a43d4f5.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1552053831-71594a27632d.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{asset('site/images/photo-1583511655826-05700d52f4d9.jpeg')}}"
                        class="img-fluid rounded" alt="Instagram Post">
                </a>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-dark"><i class="bi bi-instagram me-2"></i>صفحه اینستاگرام ما</a>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">در خبرنامه توکا پت عضو شوید</h3>
                    <p class="mb-5">تخفیف‌های ویژه، محصولات جدید و نکات مراقبت از حیوانات را دریافت کنید</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="آدرس ایمیل شما">
                        <button class="btn btn-dark" type="button">عضویت</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
