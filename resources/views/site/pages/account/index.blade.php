@extends('layout.app')

@section('title', 'حساب کاربری')
@section('styles')
<style>
    .account-page { min-height: 70vh; padding: 42px 0 70px; background: #f7f8fa; }
    .account-head, .account-card { background:#fff; border:1px solid #e7eaee; border-radius:20px; box-shadow:0 8px 28px rgba(31,41,55,.05); }
    .account-head { padding:22px; display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:20px; }
    .account-head h1 { font-size:1.35rem; font-weight:950; margin:0 0 5px; }
    .account-phone { color:#737e88; direction:ltr; text-align:right; }
    .account-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
    .stat-box { padding:18px; background:#fff; border:1px solid #e7eaee; border-radius:17px; }
    .stat-box span { display:block; color:#78838d; font-size:.82rem; margin-bottom:7px; }
    .stat-box strong { font-size:1.12rem; }
    .account-card { overflow:hidden; }
    .account-card-title { padding:18px 20px; margin:0; font-size:1.05rem; font-weight:900; border-bottom:1px solid #edf0f2; }
    .order-row { padding:17px 20px; display:grid; grid-template-columns:1.2fr 1fr 1fr auto; align-items:center; gap:14px; border-bottom:1px solid #f0f2f4; }
    .order-row:last-child { border:0; }
    .order-label { color:#7b858e; font-size:.77rem; display:block; margin-bottom:4px; }
    .order-status { display:inline-flex; padding:5px 10px; border-radius:999px; background:#eef8f5; color:#19765b; font-size:.78rem; font-weight:800; }
    .order-status.pending { background:#fff6df; color:#946600; }
    .order-link { color:#e94560; text-decoration:none; font-weight:850; white-space:nowrap; }
    .order-products { display:flex; flex-wrap:wrap; gap:5px; margin-top:7px; }
    .order-product-link { color:#596570; background:#f3f5f7; border-radius:999px; padding:3px 8px; text-decoration:none; font-size:.72rem; font-weight:750; }
    .order-product-link:hover { color:#fff; background:#e94560; }
    @media(max-width:767px){.account-stats{grid-template-columns:1fr}.account-head{align-items:flex-start;flex-direction:column}.order-row{grid-template-columns:1fr 1fr}.order-link{grid-column:1/-1}.order-row>div:nth-child(3){grid-column:1/-1}}
</style>
@endsection

@section('content')
<main class="account-page"><div class="container">
    <div class="account-head">
        <div><h1>سلام {{ $user->name }}</h1><div class="account-phone">{{ $user->phone }}</div></div>
        @if($stats['open_cart'])<a class="btn btn-outline-dark rounded-pill" href="{{ route('cart.mycart') }}">مشاهده سبد باز</a>@endif
    </div>
    <div class="account-stats">
        <div class="stat-box"><span>سفارش‌های ثبت‌شده</span><strong>{{ number_format($stats['orders']) }}</strong></div>
        <div class="stat-box"><span>مجموع خرید موفق</span><strong>{{ number_format($stats['paid']) }} تومان</strong></div>
        <div class="stat-box"><span>وضعیت سبد</span><strong>{{ $stats['open_cart'] ? 'سبد باز دارید' : 'سبد باز ندارید' }}</strong></div>
    </div>
    <section class="account-card">
        <h2 class="account-card-title">سفارش‌ها و سبدهای من</h2>
        @forelse($orders as $order)
            <article class="order-row">
                <div><span class="order-label">شماره سفارش</span><strong>#{{ $order->id }}</strong><div class="order-products">@foreach($order->items as $item) @if($item->product)<a class="order-product-link" href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }} × {{ $item->quantity }}</a>@else<span class="order-product-link">محصول حذف‌شده</span>@endif @endforeach</div></div>
                <div><span class="order-label">تاریخ</span>{{ jdate($order->created_at)->format('Y/m/d H:i') }}</div>
                <div><span class="order-label">مبلغ و وضعیت</span><strong>{{ number_format($order->final_price) }} تومان</strong> <span class="order-status {{ $order->status }}">{{ $order->status_fa }}</span></div>
                <a class="order-link" href="{{ route('account.orders.show', $order) }}">جزئیات <i class="bi bi-chevron-left"></i></a>
            </article>
        @empty
            <div class="text-center text-muted p-5">هنوز سفارشی ثبت نکرده‌اید.</div>
        @endforelse
    </section>
    <div class="mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
</div></main>
@endsection
