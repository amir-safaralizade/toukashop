@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('page.home') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i> خانه</a></li>
                <li class="breadcrumb-item active" aria-current="page">سفارشات من</li>
            </ol>
        </nav>
    </div>

    <section class="container my-5">
        <div class="card shadow-sm border-0"> 
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2 text-primary"></i> سفارشات من</h4>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-shopping-cart me-2"></i>خرید جدید
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap">شماره سفارش</th>
                                <th>تاریخ</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                                <th>روش پرداخت</th>
                                <th class="text-end">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- سفارش در حال پردازش -->
                            <tr>
                                <td class="fw-bold">#ORD-12345</td>
                                <td>
                                    <span class="d-block">۱۴۰۲/۰۵/۲۰</span>
                                    <span class="small text-muted">12:30 بعدازظهر</span>
                                </td>
                                <td>۱,۲۵۰,۰۰۰ تومان</td>
                                <td>
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-spinner fa-pulse me-1"></i> در حال پردازش
                                    </span>
                                </td>
                                <td>پرداخت آنلاین</td>
                                <td class="text-end">
                                    <a href="{{ route('order.details', 12345) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> مشاهده
                                    </a>
                                </td>
                            </tr>

                            <!-- سفارش تحویل شده -->
                            <tr>
                                <td class="fw-bold">#ORD-12344</td>
                                <td>
                                    <span class="d-block">۱۴۰۲/۰۵/۱۵</span>
                                    <span class="small text-muted">10:15 صبح</span>
                                </td>
                                <td>۸۷۵,۰۰۰ تومان</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle me-1"></i> تحویل شده
                                    </span>
                                </td>
                                <td>پرداخت آنلاین</td>
                                <td class="text-end">
                                    <a href="{{ route('order.details', 12344) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> مشاهده
                                    </a>
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 ms-2">
                                        <i class="fas fa-redo me-1"></i> خرید مجدد
                                    </button>
                                </td>
                            </tr>

                            <!-- سفارش در انتظار پرداخت کارت به کارت -->
                            <tr>
                                <td class="fw-bold">#ORD-12343</td>
                                <td>
                                    <span class="d-block">۱۴۰۲/۰۵/۱۰</span>
                                    <span class="small text-muted">03:45 بعدازظهر</span>
                                </td>
                                <td>۲,۳۴۰,۰۰۰ تومان</td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="fas fa-clock me-1"></i> در انتظار پرداخت
                                    </span>
                                </td>
                                <td>کارت به کارت</td>
                                <td class="text-end">
                                    <a href="{{ route('order.details', 12343) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> مشاهده
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-2">
                                        <i class="fas fa-times me-1"></i> لغو سفارش
                                    </button>
                                </td>
                            </tr>

                            <!-- سفارش لغو شده -->
                            <tr>
                                <td class="fw-bold">#ORD-12342</td>
                                <td>
                                    <span class="d-block">۱۴۰۲/۰۵/۰۵</span>
                                    <span class="small text-muted">09:20 صبح</span>
                                </td>
                                <td>۱,۷۵۰,۰۰۰ تومان</td>
                                <td>
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        <i class="fas fa-times-circle me-1"></i> لغو شده
                                    </span>
                                </td>
                                <td>پرداخت آنلاین</td>
                                <td class="text-end">
                                    <a href="{{ route('order.details', 12342) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> مشاهده
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- صفحه بندی -->
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .pagination .page-item.active .page-link {
            background-color: #4361ee;
            border-color: #4361ee;
        }

        .pagination .page-link {
            color: #4361ee;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
    </style>
@endsection