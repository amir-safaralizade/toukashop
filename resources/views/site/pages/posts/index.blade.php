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
    
    .articles-archive {
        padding: 5rem 0;
        background-color: var(--cream);
        min-height: 100vh;
    }
    
    .archive-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .archive-title {
        font-family: "Dancing Script", cursive;
        font-size: 3rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }
    
    .archive-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(to right, var(--pink), var(--purple));
    }
    
    .archive-description {
        color: var(--text-dark);
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
    }
    
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .article-card {
        background-color: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(179, 153, 212, 0.1);
        transition: all 0.3s ease;
    }
    
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(179, 153, 212, 0.2);
    }
    
    .article-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .article-content {
        padding: 1.5rem;
    }
    
    .article-title {
        font-family: "Dancing Script", cursive;
        font-size: 1.5rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .article-excerpt {
        color: var(--text-dark);
        opacity: 0.8;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        font-size: 0.85rem;
        color: var(--text-dark);
        opacity: 0.7;
    }
    
    .read-more {
        display: inline-block;
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .read-more:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.3);
    }
    
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .tag {
        background-color: var(--light-purple);
        color: var(--text-dark);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
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
    }
    
    .pagination-link:hover,
    .pagination-link.active {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
    }
    
    .categories-filter {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .category-btn {
        background-color: var(--white);
        color: var(--text-dark);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid var(--light-purple);
    }
    
    .category-btn:hover,
    .category-btn.active {
        background: linear-gradient(to right, var(--pink), var(--purple));
        color: var(--white);
        border-color: transparent;
    }
    
    /* رسپانسیو */
    @media (max-width: 768px) {
        .archive-title {
            font-size: 2.2rem;
        }
        
        .articles-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<section class="articles-archive" style="margin-top: 128px">
    <div class="container">
        <div class="archive-header">
            <h1 class="archive-title">آرشیو مقالات</h1>
            <p class="archive-description">
                در این بخش می‌توانید تمام مقالات آموزشی، راهنماها و نکات مفید در مورد کفش‌های ورزشی و مراقبت از پا را مطالعه کنید.
            </p>
        </div>
        
        <div class="categories-filter">
            <button class="category-btn active">همه مقالات</button>
            <button class="category-btn">کفش دویدن</button>
            <button class="category-btn">کفش بدنسازی</button>
            <button class="category-btn">مراقبت از پا</button>
            <button class="category-btn">تغذیه و ورزش</button>
        </div>
        
        <div class="articles-grid">
            <!-- مقاله ۱ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                     alt="کفش ورزشی" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">راهنمای انتخاب کفش ورزشی مناسب</h2>
                    <p class="article-excerpt">
                        انتخاب کفش ورزشی مناسب یکی از مهم‌ترین عوامل در بهبود عملکرد و جلوگیری از آسیب‌های ورزشی است...
                    </p>
                    <div class="tags-container">
                        <span class="tag">کفش ورزشی</span>
                        <span class="tag">سلامت</span>
                    </div>
                    <div class="article-meta">
                        <span>۲۵ خرداد ۱۴۰۲</span>
                        <span>۱,۲۴۵ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
            
            <!-- مقاله ۲ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                     alt="کفش دویدن" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">۱۰ نکته طلایی برای انتخاب کفش دویدن</h2>
                    <p class="article-excerpt">
                        اگر به دنبال بهبود عملکرد دویدن خود هستید، انتخاب کفش مناسب اولین قدم است...
                    </p>
                    <div class="tags-container">
                        <span class="tag">دویدن</span>
                        <span class="tag">کفش</span>
                    </div>
                    <div class="article-meta">
                        <span>۱۸ خرداد ۱۴۰۲</span>
                        <span>۹۸۷ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
            
            <!-- مقاله ۳ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a" 
                     alt="کفش بدنسازی" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">کفش بدنسازی مناسب چه ویژگی‌هایی دارد؟</h2>
                    <p class="article-excerpt">
                        کفش بدنسازی با کفش دویدن تفاوت‌های اساسی دارد. در این مقاله به بررسی ویژگی‌های یک کفش بدنسازی ایده‌آل می‌پردازیم...
                    </p>
                    <div class="tags-container">
                        <span class="tag">بدنسازی</span>
                        <span class="tag">تمرین</span>
                    </div>
                    <div class="article-meta">
                        <span>۱۰ خرداد ۱۴۰۲</span>
                        <span>۱,۵۶۲ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
            
            <!-- مقاله ۴ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06" 
                     alt="مراقبت از پا" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">راهکارهای ساده برای مراقبت از پاها</h2>
                    <p class="article-excerpt">
                        پاهای شما بار تمام وزن بدن را تحمل می‌کنند. با این راهکارهای ساده می‌توانید از پاهای خود بهتر مراقبت کنید...
                    </p>
                    <div class="tags-container">
                        <span class="tag">سلامت</span>
                        <span class="tag">مراقبت</span>
                    </div>
                    <div class="article-meta">
                        <span>۵ خرداد ۱۴۰۲</span>
                        <span>۲,۰۴۳ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
            
            <!-- مقاله ۵ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b" 
                     alt="کفش پیاده‌روی" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">بهترین کفش‌ها برای پیاده‌روی طولانی</h2>
                    <p class="article-excerpt">
                        اگر عاشق پیاده‌روی هستید، انتخاب کفش مناسب می‌تواند تجربه شما را کاملاً دگرگون کند...
                    </p>
                    <div class="tags-container">
                        <span class="tag">پیاده‌روی</span>
                        <span class="tag">کفش</span>
                    </div>
                    <div class="article-meta">
                        <span>۲۸ اردیبهشت ۱۴۰۲</span>
                        <span>۱,۳۲۱ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
            
            <!-- مقاله ۶ -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c" 
                     alt="تغذیه و ورزش" 
                     class="article-image">
                <div class="article-content">
                    <h2 class="article-title">تغذیه مناسب برای ورزشکاران</h2>
                    <p class="article-excerpt">
                        تغذیه مناسب نقش کلیدی در عملکرد ورزشی دارد. در این مقاله به بررسی رژیم غذایی ایده‌آل برای ورزشکاران می‌پردازیم...
                    </p>
                    <div class="tags-container">
                        <span class="tag">تغذیه</span>
                        <span class="tag">ورزش</span>
                    </div>
                    <div class="article-meta">
                        <span>۲۰ اردیبهشت ۱۴۰۲</span>
                        <span>۲,۵۶۷ بازدید</span>
                    </div>
                    <a href="#" class="read-more">مطالعه بیشتر</a>
                </div>
            </div>
        </div>
        
        <div class="pagination">
            <a href="#" class="pagination-link active">1</a>
            <a href="#" class="pagination-link">2</a>
            <a href="#" class="pagination-link">3</a>
            <a href="#" class="pagination-link">4</a>
            <a href="#" class="pagination-link">5</a>
        </div>
    </div>
</section>
@endsection