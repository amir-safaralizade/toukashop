@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('page.home') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i> خانه</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none">سفارشات من</a></li>
                <li class="breadcrumb-item active" aria-current="page">جزئیات سفارش #ORD-12345</li>
            </ol>
        </nav>
    </div>

    <section class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-box-open me-2 text-primary"></i> جزئیات سفارش</h4>
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-spinner fa-pulse me-1"></i> در حال پردازش
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th>محصول</th>
                                        <th class="text-center">تعداد</th>
                                        <th class="text-end">قیمت واحد</th>
                                        <th class="text-end">جمع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/80" class="img-fluid rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="محصول">
                                                <div>
                                                    <h6 class="mb-1">گوشی موبایل سامسونگ مدل Galaxy A72</h6>
                                                    <p class="small text-muted mb-0">کد محصول: PRD-1001</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-end align-middle">۱۲,۵۰۰,۰۰۰ تومان</td>
                                        <td class="text-end align-middle">۱۲,۵۰۰,۰۰۰ تومان</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/80" class="img-fluid rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="محصول">
                                                <div>
                                                    <h6 class="mb-1">هدفون بی سیم مدل Soundcore Life Q30</h6>
                                                    <p class="small text-muted mb-0">کد محصول: PRD-2045</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">2</td>
                                        <td class="text-end align-middle">۳,۲۵۰,۰۰۰ تومان</td>
                                        <td class="text-end align-middle">۶,۵۰۰,۰۰۰ تومان</td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">جمع کل:</td>
                                        <td class="text-end fw-bold">۱۹,۰۰۰,۰۰۰ تومان</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">تخفیف:</td>
                                        <td class="text-end fw-bold text-success">-۱,۵۰۰,۰۰۰ تومان</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">هزینه ارسال:</td>
                                        <td class="text-end fw-bold text-success">رایگان</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end h5">مبلغ قابل پرداخت:</td>
                                        <td class="text-end h5 text-danger">۱۷,۵۰۰,۰۰۰ تومان</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- وضعیت سفارش -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-truck me-2 text-primary"></i> وضعیت ارسال</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item completed">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">سفارش ثبت شد</h6>
                                    <p class="small text-muted mb-0">۱۴۰۲/۰۵/۲۰ - ۱۲:۳۰ بعدازظهر</p>
                                </div>
                            </div>
                            <div class="timeline-item completed">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">پرداخت تایید شد</h6>
                                    <p class="small text-muted mb-0">۱۴۰۲/۰۵/۲۰ - ۱۲:۴۵ بعدازظهر</p>
                                </div>
                            </div>
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-spinner fa-pulse"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">در حال آماده‌سازی سفارش</h6>
                                    <p class="small text-muted mb-0">۱۴۰۲/۰۵/۲۰ - ۰۱:۱۵ بعدازظهر</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">تحویل به پست</h6>
                                    <p class="small text-muted mb-0">در انتظار</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">تحویل به مشتری</h6>
                                    <p class="small text-muted mb-0">در انتظار</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 py-3">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i> اطلاعات سفارش</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">اطلاعات پرداخت</h6>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>شماره سفارش:</span>
                                    <span class="fw-bold">#ORD-12345</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>تاریخ سفارش:</span>
                                    <span>۱۴۰۲/۰۵/۲۰ - ۱۲:۳۰ بعدازظهر</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>روش پرداخت:</span>
                                    <span>پرداخت آنلاین</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>وضعیت پرداخت:</span>
                                    <span class="badge bg-success bg-opacity-10 text-success">پرداخت موفق</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">اطلاعات ارسال</h6>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>نام تحویل‌گیرنده:</span>
                                    <span>علی محمدی</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>شماره تماس:</span>
                                    <span>۰۹۱۲۳۴۵۶۷۸۹</span>
                                </li>
                                <li class="list-group-item px-0 py-2 border-0">
                                    <span class="d-block mb-1">آدرس:</span>
                                    <span class="text-muted">تهران، خیابان آزادی، کوچه شهید فلانی، پلاک ۱۲۳، طبقه ۲، واحد ۴</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>روش ارسال:</span>
                                    <span>پست پیشتاز</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <span>زمان تحویل:</span>
                                    <span>۱-۲ روز کاری</span>
                                </li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-print me-2"></i> چاپ فاکتور
                            </button>
                            <button class="btn btn-outline-danger rounded-pill">
                                <i class="fas fa-times me-2"></i> درخواست لغو سفارش
                            </button>
                            <button class="btn btn-outline-success rounded-pill">
                                <i class="fas fa-redo me-2"></i> خرید مجدد
                            </button>
                        </div>

                        <div class="alert alert-light border mt-4">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-headset text-primary mt-1 me-2"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">نیاز به کمک دارید؟</h6>
                                    <p class="small mb-0">در صورت وجود هرگونه سوال یا مشکل در مورد سفارش خود، می‌توانید با پشتیبانی ما تماس بگیرید.</p>
                                    <a href="#" class="btn btn-sm btn-link p-0 mt-2">تماس با پشتیبانی <i class="fas fa-arrow-left ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 1.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-icon {
            position: absolute;
            left: -1.5rem;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border: 2px solid #e9ecef;
            z-index: 1;
        }

        .timeline-item.completed .timeline-icon {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .timeline-item.active .timeline-icon {
            background-color: #4361ee;
            color: white;
            border-color: #4361ee;
            animation: pulse 2s infinite;
        }

        .timeline-content {
            padding-left: 1.5rem;
        }

        .timeline-item.completed::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            height: 100%;
            width: 2px;
            background-color: #28a745;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(67, 97, 238, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
            }
        }

        .list-group-item {
            padding-right: 0;
        }
    </style>
@endsection