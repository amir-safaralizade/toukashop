@extends('layout.app')

@section('styles')
<style>
    /* استایل کلی صفحه مقاله */
    .article-main {
        padding: 4rem 0;
        background-color: #f9f5ff;
    }
    
    .article-container {
        background-color: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
        max-width: 900px;
        margin: 0 auto;
    }
    
    .article-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .article-title {
        font-family: "Dancing Script", cursive;
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .article-meta {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        color: #777;
        margin-bottom: 1.5rem;
    }
    
    .article-meta-item {
        display: flex;
        align-items: center;
    }
    
    .article-meta-item i {
        margin-left: 0.5rem;
    }
    
    .article-image {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #444;
    }
    
    .article-content h2,
    .article-content h3 {
        font-family: "Dancing Script", cursive;
        color: #8e44ad;
        margin: 1.5rem 0 1rem;
    }
    
    .article-content h2 {
        font-size: 1.8rem;
    }
    
    .article-content h3 {
        font-size: 1.5rem;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
    }
    
    .article-content img {
        max-width: 100%;
        border-radius: 10px;
        margin: 1rem 0;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .article-content blockquote {
        border-right: 4px solid #8e44ad;
        padding-right: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #555;
    }
    
    .article-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(179, 153, 212, 0.2);
    }
    
    .article-tag {
        background-color: #f3e6ff;
        color: #8e44ad;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .article-tag:hover {
        background-color: #8e44ad;
        color: white;
    }
    
    /* بخش نظرات */
    .comments-section {
        margin-top: 3rem;
    }
    
    .comments-title {
        font-family: "Dancing Script", cursive;
        font-size: 2rem;
        color: #333;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid rgba(179, 153, 212, 0.2);
        padding-bottom: 0.5rem;
    }
    
    .comment {
        background-color: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
    }
    
    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .comment-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-left: 1rem;
    }
    
    .comment-author {
        font-weight: 600;
    }
    
    .comment-date {
        font-size: 0.9rem;
        color: #777;
    }
    
    .comment-content {
        line-height: 1.7;
    }
    
    /* فرم ارسال نظر */
    .comment-form {
        background-color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 5px 15px rgba(179, 153, 212, 0.1);
    }
    
    .comment-form-title {
        font-family: "Dancing Script", cursive;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #555;
    }
    
    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #8e44ad;
        box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.1);
    }
    
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
    
    .submit-btn {
        background: linear-gradient(45deg, #f8c1ba, #8e44ad);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
    }
    
    /* رسپانسیو */
    @media (max-width: 768px) {
        .article-container {
            padding: 1.5rem;
        }
        
        .article-title {
            font-size: 2rem;
        }
        
        .article-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }
    }
</style>
@endsection

@section('content')
<main class="article-main" style="margin-top: 128px">
    <div class="container">
        <div class="article-container">
            <!-- هدر مقاله -->
            <div class="article-header">
                <h1 class="article-title">راهنمای انتخاب کفش ورزشی مناسب</h1>
                
                <div class="article-meta">
                    <span class="article-meta-item">
                        <i class="bi bi-person"></i> نویسنده: تیم ونل
                    </span>
                    <span class="article-meta-item">
                        <i class="bi bi-calendar"></i> ۲۵ خرداد ۱۴۰۲
                    </span>
                    <span class="article-meta-item">
                        <i class="bi bi-eye"></i> ۱,۲۴۵ بازدید
                    </span>
                </div>
                
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff" 
                     alt="کفش ورزشی" 
                     class="article-image">
            </div>
            
            <!-- محتوای مقاله -->
            <div class="article-content">
                <p>انتخاب کفش ورزشی مناسب یکی از مهم‌ترین عوامل در بهبود عملکرد و جلوگیری از آسیب‌های ورزشی است. در این مقاله به بررسی نکات کلیدی برای انتخاب بهترین کفش ورزشی می‌پردازیم.</p>
                
                <h2>۱. شناخت نوع ورزش</h2>
                <p>هر رشته ورزشی نیازمند کفش مخصوص به خود است. کفش دویدن با کفش بسکتبال یا فوتبال تفاوت‌های اساسی دارد.</p>
                
                <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28" 
                     alt="انواع کفش ورزشی">
                
                <h3>کفش دویدن</h3>
                <p>کفش‌های دویدن باید سبک باشند و ضربه‌گیری مناسبی داشته باشند. به دنبال کفش‌هایی با کفی نرم و انعطاف‌پذیر باشید.</p>
                
                <h3>کفش بدنسازی</h3>
                <p>برای تمرینات بدنسازی به کفش‌هایی با کفی صاف و پایدار نیاز دارید که از مچ پا حمایت کنند.</p>
                
                <blockquote>
                    یک کفش ورزشی خوب نه تنها عملکرد شما را بهبود می‌بخشد، بلکه از آسیب‌های طولانی مدت به مفاصل جلوگیری می‌کند.
                </blockquote>
                
                <h2>۲. توجه به نوع کف پا</h2>
                <p>سه نوع کلی کف پا وجود دارد که هر کدام نیازمند کفش مخصوص هستند:</p>
                
                <ul>
                    <li>کف پای صاف</li>
                    <li>کف پای معمولی</li>
                    <li>کف پای گود</li>
                </ul>
                
                <h2>۳. انتخاب سایز مناسب</h2>
                <p>کفش ورزشی باید کمی فضای اضافه در جلوی انگشتان داشته باشد. بهترین زمان برای اندازه‌گیری کف پا، پایان روز است که پاها در بزرگ‌ترین اندازه خود هستند.</p>
            </div>
            
            <!-- تگ‌های مقاله -->
            <div class="article-tags">
                <a href="#" class="article-tag">کفش ورزشی</a>
                <a href="#" class="article-tag">ورزش</a>
                <a href="#" class="article-tag">سلامت</a>
                <a href="#" class="article-tag">تجهیزات ورزشی</a>
            </div>
            
            <!-- بخش نظرات -->
            <div class="comments-section">
                <h3 class="comments-title">نظرات کاربران</h3>
                
                <div class="comment">
                    <div class="comment-header">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" 
                             alt="نازنین محمدی" 
                             class="comment-avatar">
                        <div>
                            <div class="comment-author">نازنین محمدی</div>
                            <div class="comment-date">۱۵ خرداد ۱۴۰۲</div>
                        </div>
                    </div>
                    <div class="comment-content">
                        ممنون از مقاله عالی‌تون. من همیشه در انتخاب کفش ورزشی مشکل داشتم و این مطلب خیلی بهم کمک کرد.
                    </div>
                </div>
                
                <div class="comment">
                    <div class="comment-header">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" 
                             alt="امیرحسین رضایی" 
                             class="comment-avatar">
                        <div>
                            <div class="comment-author">امیرحسین رضایی</div>
                            <div class="comment-date">۱۰ خرداد ۱۴۰۲</div>
                        </div>
                    </div>
                    <div class="comment-content">
                        لطفاً در مورد کفش‌های مخصوص پیاده‌روی هم مقاله بذارید. ممنون
                    </div>
                </div>
                
                <!-- فرم ارسال نظر -->
                <div class="comment-form">
                    <h3 class="comment-form-title">ثبت نظر جدید</h3>
                    
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">نام شما *</label>
                                    <input type="text" id="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">ایمیل (اختیاری)</label>
                                    <input type="email" id="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="comment" class="form-label">نظر شما *</label>
                            <textarea id="comment" class="form-control" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="bi bi-send"></i> ارسال نظر
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection