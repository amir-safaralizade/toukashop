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
    
    .products-archive {
        padding: 4rem 0;
        background-color: var(--cream);
    }
    
    .archive-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .archive-title {
        font-family: "Dancing Script", cursive;
        font-size: 2.8rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }
    
    .archive-description {
        color: var(--text-dark);
        opacity: 0.8;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }
    
    .categories-filter {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }
    
    .category-btn {
        background-color: var(--white);
        color: var(--text-dark);
        padding: 0.7rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid var(--light-purple);
        text-decoration: none;
    }
    
    .category-btn:hover,
    .category-btn.active {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        border-color: transparent;
        transform: translateY(-3px);
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }
    
    .product-card {
        background-color: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(179, 153, 212, 0.2);
    }
    
    .product-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--purple);
        color: var(--white);
        padding: 0.3rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }
    
    .product-image-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.1);
    }
    
    .product-content {
        padding: 1.5rem;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        height: 50px;
        overflow: hidden;
    }
    
    .product-price {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .current-price {
        font-weight: 700;
        color: var(--purple);
        font-size: 1.2rem;
    }
    
    .old-price {
        text-decoration: line-through;
        color: var(--text-dark);
        opacity: 0.6;
        font-size: 0.9rem;
    }
    
    .product-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(179, 153, 212, 0.2);
    }
    
    .add-to-wishlist {
        background-color: transparent;
        border: none;
        color: var(--light-pink);
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .add-to-wishlist:hover,
    .add-to-wishlist.active {
        color: var(--dark-pink);
        transform: scale(1.2);
    }
    
    .add-to-cart {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .add-to-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(179, 153, 212, 0.3);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }
    
    .pagination-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        border-radius: 50%;
        background-color: var(--white);
        color: var(--text-dark);
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .pagination-link:hover,
    .pagination-link.active {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
    }
    
    /* رسپانسیو */
    @media (max-width: 768px) {
        .archive-title {
            font-size: 2.2rem;
        }
        
        .categories-filter {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 1rem;
            flex-wrap: nowrap;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }
</style>
@endsection

@section('content')
<section class="products-archive" style="margin-top: 128px">
    <div class="container">
        <div class="archive-header">
            <h1 class="archive-title">محصولات ما</h1>
            <p class="archive-description">بهترین و باکیفیت‌ترین کفش‌های ورزشی را در فروشگاه ونل پیدا کنید</p>
        </div>
        
        <div class="categories-filter">
            <a href="#" class="category-btn active">همه محصولات</a>
            <a href="#" class="category-btn">کفش دویدن</a>
            <a href="#" class="category-btn">کفش بدنسازی</a>
            <a href="#" class="category-btn">کفش پیاده‌روی</a>
            <a href="#" class="category-btn">کفش کوهنوردی</a>
            <a href="#" class="category-btn">تخفیف‌دارها</a>
            <a href="#" class="category-btn">پرفروش‌ها</a>
        </div>
        
        <div class="products-grid">
            <!-- محصول ۱ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <span class="product-badge">۱۵٪ تخفیف</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                             alt="کفش ورزشی مردانه" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش ورزشی مردانه مدل Runner X - کد ۱۲۳۴</h3>
                        <div class="product-price">
                            <span class="current-price">۱,۲۵۰,۰۰۰ تومان</span>
                            <span class="old-price">۱,۴۷۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
            
            <!-- محصول ۲ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <span class="product-badge">پرفروش</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" 
                             alt="کفش بدنسازی" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش بدنسازی حرفه ای مدل Power - کد ۵۶۷۸</h3>
                        <div class="product-price">
                            <span class="current-price">۹۸۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist active">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
            
            <!-- محصول ۳ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                             alt="کفش دویدن زنانه" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش دویدن زنانه مدل Light - کد ۹۰۱۲</h3>
                        <div class="product-price">
                            <span class="current-price">۱,۱۲۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
            
            <!-- محصول ۴ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <span class="product-badge">جدید</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06" 
                             alt="کفش پیاده‌روی" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش پیاده‌روی طبی مدل Comfort - کد ۳۴۵۶</h3>
                        <div class="product-price">
                            <span class="current-price">۸۵۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
            
            <!-- محصول ۵ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <span class="product-badge">۱۰٪ تخفیف</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b" 
                             alt="کفش کوهنوردی" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش کوهنوردی حرفه ای مدل Mountain - کد ۷۸۹۰</h3>
                        <div class="product-price">
                            <span class="current-price">۱,۳۵۰,۰۰۰ تومان</span>
                            <span class="old-price">۱,۵۰۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
            
            <!-- محصول ۶ -->
            <div class="product-card">
                <a href="#" class="product-link">
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c" 
                             alt="کفش ورزشی زنانه" 
                             class="product-image">
                    </div>
                    <div class="product-content">
                        <h3 class="product-name">کفش ورزشی زنانه مدل Flex - کد ۲۳۴۵</h3>
                        <div class="product-price">
                            <span class="current-price">۱,۰۵۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </a>
                <div class="product-actions">
                    <button class="add-to-wishlist active">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                    <button class="add-to-cart">افزودن به سبد</button>
                </div>
            </div>
        </div>
        
        <div class="pagination">
            <a href="#" class="pagination-link">
                <i class="bi bi-chevron-left"></i>
            </a>
            <a href="#" class="pagination-link active">1</a>
            <a href="#" class="pagination-link">2</a>
            <a href="#" class="pagination-link">3</a>
            <a href="#" class="pagination-link">4</a>
            <a href="#" class="pagination-link">
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection