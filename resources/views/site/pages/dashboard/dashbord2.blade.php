@extends('layout.app')

@section('styles')
<style>
    /* استایل‌های قبلی را حفظ کنید و این استایل‌های جدید را اضافه کنید */

    .order-detail-container {
        background-color: var(--white);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
        margin-bottom: 2rem;
    }

    .order-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(179, 153, 212, 0.2);
    }

    .order-number {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .order-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .order-detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .order-products {
        margin-top: 1.5rem;
    }

    .order-product-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(179, 153, 212, 0.1);
    }

    .order-product-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        margin-left: 1.5rem;
    }

    .order-product-info {
        flex: 1;
    }

    .order-product-name {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .order-product-sku {
        font-size: 0.9rem;
        color: var(--text-dark);
        opacity: 0.7;
        margin-bottom: 0.5rem;
    }

    .order-product-price {
        font-weight: 600;
        color: var(--purple);
    }

    .order-product-quantity {
        width: 100px;
        text-align: center;
    }

    .order-summary {
        background-color: var(--cream);
        border-radius: 10px;
        padding: 1.5rem;
    }

    .summary-title {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
        font-size: 1.2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .summary-label {
        color: var(--text-dark);
        opacity: 0.8;
    }

    .summary-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    .summary-total {
        border-top: 1px solid rgba(179, 153, 212, 0.3);
        padding-top: 1rem;
        margin-top: 1rem;
        font-size: 1.1rem;
    }

    .summary-total .summary-value {
        color: var(--purple);
        font-size: 1.3rem;
    }

    .order-address {
        margin-top: 2rem;
    }

    .address-card {
        background-color: var(--cream);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .address-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .address-details {
        line-height: 1.7;
        color: var(--text-dark);
    }

    .order-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .print-btn {
        background-color: var(--light-purple);
        color: var(--text-dark);
    }

    .cancel-btn {
        background-color: var(--light-pink);
        color: var(--text-dark);
    }

    .track-btn {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.2);
    }

    @media (max-width: 768px) {
        .order-detail-grid {
            grid-template-columns: 1fr;
        }
        
        .order-product-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-product-image {
            margin-left: 0;
            margin-bottom: 1rem;
        }
        
        .order-actions {
            flex-direction: column;
        }
    }
</style>


@endsection

@section('content')
<section class="user-dashboard" style="margin-top: 128px">
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">جزئیات سفارش</h1>
            <p class="welcome-message">مشاهده اطلاعات کامل سفارش شما</p>
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
                        <a href="#" class="nav-link active">
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
            
            <!-- محتوای اصلی - جزئیات سفارش -->
            <main class="main-content">
                <div class="order-detail-container">
                    <div class="order-detail-header">
                        <h2 class="order-number">سفارش #VN-2023-1254</h2>
                        <span class="order-status-badge status-processing">در حال پردازش</span>
                    </div>
                    
                    <div class="order-detail-grid">
                        <div>
                            <h3 class="section-title">محصولات سفارش</h3>
                            
                            <div class="order-products">
                                <!-- محصول ۱ -->
                                <div class="order-product-item">
                                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                                         alt="کفش ورزشی" 
                                         class="order-product-image">
                                    <div class="order-product-info">
                                        <h4 class="order-product-name">کفش ورزشی مردانه مدل Runner X</h4>
                                        <div class="order-product-sku">کد محصول: VN-RUN-2023</div>
                                        <div class="order-product-price">۱,۲۵۰,۰۰۰ تومان</div>
                                    </div>
                                    <div class="order-product-quantity">× 1</div>
                                </div>
                                
                                <!-- محصول ۲ -->
                                <div class="order-product-item">
                                    <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" 
                                         alt="کفش بدنسازی" 
                                         class="order-product-image">
                                    <div class="order-product-info">
                                        <h4 class="order-product-name">کفش بدنسازی حرفه ای مدل Power</h4>
                                        <div class="order-product-sku">کد محصول: VN-PWR-2023</div>
                                        <div class="order-product-price">۹۸۰,۰۰۰ تومان</div>
                                    </div>
                                    <div class="order-product-quantity">× 1</div>
                                </div>
                                
                                <!-- محصول ۳ -->
                                <div class="order-product-item">
                                    <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                                         alt="کفش دویدن" 
                                         class="order-product-image">
                                    <div class="order-product-info">
                                        <h4 class="order-product-name">کفش دویدن زنانه مدل Light</h4>
                                        <div class="order-product-sku">کد محصول: VN-LGT-2023</div>
                                        <div class="order-product-price">۱,۱۲۰,۰۰۰ تومان</div>
                                    </div>
                                    <div class="order-product-quantity">× 2</div>
                                </div>
                            </div>
                            
                            <div class="order-address">
                                <h3 class="section-title">آدرس ارسال</h3>
                                <div class="address-card">
                                    <h4 class="address-title">آدرس منزل</h4>
                                    <div class="address-details">
                                        <p>تهران، خیابان آزادی، خیابان دانشگاه، پلاک ۱۲۳، واحد ۴</p>
                                        <p>کد پستی: ۱۴۳۵۶۷۸۹۱۰</p>
                                        <p>تلفن تماس: ۰۹۱۲۳۴۵۶۷۸۹</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="order-summary">
                                <h3 class="summary-title">خلاصه سفارش</h3>
                                
                                <div class="summary-row">
                                    <span class="summary-label">تاریخ سفارش:</span>
                                    <span class="summary-value">۲۵ خرداد ۱۴۰۲ - ۱۴:۳۰</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">روش پرداخت:</span>
                                    <span class="summary-value">درگاه پرداخت آنلاین (موفق)</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">روش ارسال:</span>
                                    <span class="summary-value">پست پیشتاز (رایگان)</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">زمان تحویل:</span>
                                    <span class="summary-value">۲ تا ۴ روز کاری</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">مبلغ کل:</span>
                                    <span class="summary-value">۳,۳۵۰,۰۰۰ تومان</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">تخفیف:</span>
                                    <span class="summary-value">۱۵۰,۰۰۰ تومان</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">هزینه ارسال:</span>
                                    <span class="summary-value">رایگان</span>
                                </div>
                                
                                <div class="summary-row summary-total">
                                    <span class="summary-label">مبلغ قابل پرداخت:</span>
                                    <span class="summary-value">۳,۲۰۰,۰۰۰ تومان</span>
                                </div>
                            </div>
                            
                            <div class="order-actions">
                                <button class="action-btn print-btn">
                                    <i class="bi bi-printer"></i> چاپ فاکتور
                                </button>
                                <button class="action-btn track-btn">
                                    <i class="bi bi-truck"></i> پیگیری سفارش
                                </button>
                                <button class="action-btn cancel-btn">
                                    <i class="bi bi-x-circle"></i> لغو سفارش
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
@endsection