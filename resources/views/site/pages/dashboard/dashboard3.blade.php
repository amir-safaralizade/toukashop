@extends('layout.app')

@section('styles')
<style>
    /* استایل‌های قبلی را حفظ کنید و این استایل‌های جدید را اضافه کنید */

    .wishlist-container {
        background-color: var(--white);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
    }

    .wishlist-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(179, 153, 212, 0.2);
    }

    .wishlist-title {
        font-family: "Dancing Script", cursive;
        font-size: 2rem;
        color: var(--text-dark);
    }

    .wishlist-count {
        background-color: var(--light-pink);
        color: var(--text-dark);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .wishlist-item {
        background-color: var(--cream);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .wishlist-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(179, 153, 212, 0.15);
    }

    .wishlist-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .wishlist-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .wishlist-item:hover .wishlist-image {
        transform: scale(1.05);
    }

    .wishlist-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--purple);
        color: var(--white);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .wishlist-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background-color: var(--light-pink);
        color: var(--text-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .wishlist-remove:hover {
        background-color: var(--dark-pink);
        color: var(--white);
    }

    .wishlist-details {
        padding: 1.2rem;
    }

    .wishlist-product-name {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        height: 50px;
        overflow: hidden;
    }

    .wishlist-product-price {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .current-price {
        font-weight: 700;
        color: var(--purple);
        font-size: 1.1rem;
    }

    .old-price {
        text-decoration: line-through;
        color: var(--text-dark);
        opacity: 0.6;
        font-size: 0.9rem;
    }

    .wishlist-add-to-cart {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .wishlist-add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(179, 153, 212, 0.3);
    }

    .wishlist-empty {
        text-align: center;
        padding: 3rem 0;
    }

    .wishlist-empty-icon {
        font-size: 4rem;
        color: var(--light-purple);
        margin-bottom: 1.5rem;
    }

    .wishlist-empty-title {
        font-family: "Dancing Script", cursive;
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .wishlist-empty-text {
        color: var(--text-dark);
        opacity: 0.8;
        margin-bottom: 2rem;
    }

    .wishlist-shop-btn {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .wishlist-shop-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
    }

    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
        
        .wishlist-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<section class="user-dashboard" style="margin-top: 128px">
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">لیست علاقه‌مندی‌ها</h1>
            <p class="welcome-message">محصولاتی که دوست دارید را اینجا ذخیره کنید</p>
        </div>
        
        <div class="dashboard-container">
            <!-- سایدبار (همان منوی قبلی) -->
            <aside class="sidebar">
                <div class="user-profile">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" 
                         alt="علی محمدی" 
                         class="user-avatar">
                    <h3 class="user-name">علی محمدی</h3>
                    <p class="user-email">ali.mohammadi@example.com</p>
                </div>
                
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-speedometer2"></i>
                            <span>داشبورد</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-cart-check"></i>
                            <span>سفارشات</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="bi bi-heart"></i>
                            <span>علاقه‌مندی‌ها</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-credit-card"></i>
                            <span>پرداخت‌ها</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-bag"></i>
                            <span>خریدهای من</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-gear"></i>
                            <span>تنظیمات حساب</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>خروج</span>
                        </a>
                    </li>
                </ul>
            </aside>
            
            <!-- محتوای اصلی - لیست علاقه‌مندی‌ها -->
            <main class="main-content">
                <div class="wishlist-container">
                    <div class="wishlist-header">
                        <h2 class="wishlist-title">محصولات مورد علاقه شما</h2>
                        <div class="wishlist-count">۵ محصول</div>
                    </div>
                    
                    <!-- حالت دارای محصول -->
                    <div class="wishlist-grid">
                        <!-- محصول ۱ -->
                        <div class="wishlist-item">
                            <div class="wishlist-image-container">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                                     alt="کفش ورزشی" 
                                     class="wishlist-image">
                                <span class="wishlist-badge">۱۵٪ تخفیف</span>
                                <button class="wishlist-remove">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="wishlist-details">
                                <h3 class="wishlist-product-name">کفش ورزشی مردانه مدل Runner X - کد ۱۲۳۴</h3>
                                <div class="wishlist-product-price">
                                    <div>
                                        <span class="current-price">۱,۲۵۰,۰۰۰ تومان</span>
                                        <span class="old-price">۱,۴۷۰,۰۰۰ تومان</span>
                                    </div>
                                    <button class="wishlist-add-to-cart">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- محصول ۲ -->
                        <div class="wishlist-item">
                            <div class="wishlist-image-container">
                                <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" 
                                     alt="کفش بدنسازی" 
                                     class="wishlist-image">
                                <button class="wishlist-remove">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="wishlist-details">
                                <h3 class="wishlist-product-name">کفش بدنسازی حرفه ای مدل Power - کد ۵۶۷۸</h3>
                                <div class="wishlist-product-price">
                                    <div>
                                        <span class="current-price">۹۸۰,۰۰۰ تومان</span>
                                    </div>
                                    <button class="wishlist-add-to-cart">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- محصول ۳ -->
                        <div class="wishlist-item">
                            <div class="wishlist-image-container">
                                <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                                     alt="کفش دویدن" 
                                     class="wishlist-image">
                                <span class="wishlist-badge">پرفروش</span>
                                <button class="wishlist-remove">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="wishlist-details">
                                <h3 class="wishlist-product-name">کفش دویدن زنانه مدل Light - کد ۹۰۱۲</h3>
                                <div class="wishlist-product-price">
                                    <div>
                                        <span class="current-price">۱,۱۲۰,۰۰۰ تومان</span>
                                    </div>
                                    <button class="wishlist-add-to-cart">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- محصول ۴ -->
                        <div class="wishlist-item">
                            <div class="wishlist-image-container">
                                <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06" 
                                     alt="کفش پیاده‌روی" 
                                     class="wishlist-image">
                                <button class="wishlist-remove">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="wishlist-details">
                                <h3 class="wishlist-product-name">کفش پیاده‌روی طبی مدل Comfort - کد ۳۴۵۶</h3>
                                <div class="wishlist-product-price">
                                    <div>
                                        <span class="current-price">۸۵۰,۰۰۰ تومان</span>
                                    </div>
                                    <button class="wishlist-add-to-cart">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- محصول ۵ -->
                        <div class="wishlist-item">
                            <div class="wishlist-image-container">
                                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b" 
                                     alt="کفش کوهنوردی" 
                                     class="wishlist-image">
                                <span class="wishlist-badge">جدید</span>
                                <button class="wishlist-remove">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            <div class="wishlist-details">
                                <h3 class="wishlist-product-name">کفش کوهنوردی حرفه ای مدل Mountain - کد ۷۸۹۰</h3>
                                <div class="wishlist-product-price">
                                    <div>
                                        <span class="current-price">۱,۵۰۰,۰۰۰ تومان</span>
                                    </div>
                                    <button class="wishlist-add-to-cart">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- حالت خالی (برای زمانی که محصولی وجود ندارد) -->
                    <!-- <div class="wishlist-empty">
                        <div class="wishlist-empty-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h3 class="wishlist-empty-title">لیست علاقه‌مندی‌های شما خالی است</h3>
                        <p class="wishlist-empty-text">می‌توانید با کلیک روی علامت قلب روی محصولات، آن‌ها را به این لیست اضافه کنید</p>
                        <a href="#" class="wishlist-shop-btn">مشاهده محصولات</a>
                    </div> -->
                </div>
            </main>
        </div>
    </div>
</section>
@endsection