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
        --black: #1a1a1a;
    }
    
    .user-dashboard {
        padding: 3rem 0;
        background-color: var(--cream);
        min-height: 100vh;
    }
    
    .dashboard-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .dashboard-title {
        font-family: "Dancing Script", cursive;
        font-size: 2.5rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .welcome-message {
        color: var(--text-dark);
        opacity: 0.8;
        font-size: 1.1rem;
    }
    
    .dashboard-container {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .sidebar {
        background-color: var(--white);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
        height: fit-content;
    }
    
    .user-profile {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(179, 153, 212, 0.2);
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 3px solid var(--light-pink);
    }
    
    .user-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }
    
    .user-email {
        font-size: 0.9rem;
        color: var(--text-dark);
        opacity: 0.7;
    }
    
    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .nav-item {
        margin-bottom: 0.5rem;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.8rem 1rem;
        border-radius: 10px;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover,
    .nav-link.active {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
    }
    
    .nav-link i {
        margin-left: 0.5rem;
        font-size: 1.2rem;
    }
    
    .main-content {
        background-color: var(--white);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
    }
    
    .section-title {
        font-family: "Dancing Script", cursive;
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(179, 153, 212, 0.2);
    }
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background-color: var(--cream);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(179, 153, 212, 0.1);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--purple);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--text-dark);
        opacity: 0.8;
        font-size: 0.9rem;
    }
    
    .order-card {
        background-color: var(--cream);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .order-id {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .order-date {
        font-size: 0.9rem;
        color: var(--text-dark);
        opacity: 0.7;
    }
    
    .order-status {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-processing {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .order-details {
        display: flex;
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .order-product {
        display: flex;
        align-items: center;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        margin-left: 1rem;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }
    
    .product-price {
        color: var(--purple);
        font-weight: 600;
    }
    
    .view-all {
        display: inline-block;
        margin-top: 1rem;
        color: var(--purple);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .view-all:hover {
        color: var(--dark-pink);
    }
    
    /* رسپانسیو */
    @media (max-width: 992px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
        
        .sidebar {
            order: 2;
        }
    }
    
    @media (max-width: 576px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
        
        .order-details {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<section class="user-dashboard" style="margin-top: 128px">
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">داشبورد کاربری</h1>
            <p class="welcome-message">سلام، علی! به پنل کاربری خود خوش آمدید</p>
        </div>
        
        <div class="dashboard-container">
            <!-- سایدبار -->
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
                        <a href="#" class="nav-link active">
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
                        <a href="#" class="nav-link">
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
            
            <!-- محتوای اصلی -->
            <main class="main-content">
                <h2 class="section-title">خلاصه فعالیت‌ها</h2>
                
                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-number">۳</div>
                        <div class="stat-label">سفارشات فعال</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">۱۲</div>
                        <div class="stat-label">تعداد خریدها</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">۵</div>
                        <div class="stat-label">کالاهای مورد علاقه</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">۴,۲۵۰,۰۰۰</div>
                        <div class="stat-label">تومان هزینه کل</div>
                    </div>
                </div>
                
                <h2 class="section-title">آخرین سفارشات</h2>
                
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">سفارش #VN-2023-1254</span>
                        <span class="order-date">۲۵ خرداد ۱۴۰۲</span>
                    </div>
                    <div class="order-status status-processing">در حال پردازش</div>
                    
                    <div class="order-details">
                        <div class="order-product">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                                 alt="کفش ورزشی" 
                                 class="product-image">
                            <div>
                                <h4 class="product-name">کفش ورزشی مردانه مدل Runner X</h4>
                                <div class="product-price">۱,۲۵۰,۰۰۰ تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">سفارش #VN-2023-1189</span>
                        <span class="order-date">۱۸ خرداد ۱۴۰۲</span>
                    </div>
                    <div class="order-status status-completed">تکمیل شده</div>
                    
                    <div class="order-details">
                        <div class="order-product">
                            <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" 
                                 alt="کفش بدنسازی" 
                                 class="product-image">
                            <div>
                                <h4 class="product-name">کفش بدنسازی حرفه ای مدل Power</h4>
                                <div class="product-price">۹۸۰,۰۰۰ تومان</div>
                            </div>
                        </div>
                        <div class="order-product">
                            <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                                 alt="کفش دویدن" 
                                 class="product-image">
                            <div>
                                <h4 class="product-name">کفش دویدن زنانه مدل Light</h4>
                                <div class="product-price">۱,۱۲۰,۰۰۰ تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="#" class="view-all">مشاهده همه سفارشات <i class="bi bi-arrow-left"></i></a>
                
                <h2 class="section-title" style="margin-top: 2.5rem;">کالاهای مورد علاقه</h2>
                
                <div class="order-details">
                    <div class="order-product">
                        <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06" 
                             alt="کفش پیاده‌روی" 
                             class="product-image">
                        <div>
                            <h4 class="product-name">کفش پیاده‌روی طبی مدل Comfort</h4>
                            <div class="product-price">۸۵۰,۰۰۰ تومان</div>
                        </div>
                    </div>
                    <div class="order-product">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b" 
                             alt="کفش کوهنوردی" 
                             class="product-image">
                        <div>
                            <h4 class="product-name">کفش کوهنوردی حرفه ای مدل Mountain</h4>
                            <div class="product-price">۱,۵۰۰,۰۰۰ تومان</div>
                        </div>
                    </div>
                </div>
                
                <a href="#" class="view-all">مشاهده همه علاقه‌مندی‌ها <i class="bi bi-arrow-left"></i></a>
            </main>
        </div>
    </div>
</section>
@endsection