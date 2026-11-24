@extends('layout.app')
@section('title', 'وضعیت پرداخت و سفارش')
@section('styles')
<style>
.receipt-page{background:#f6f7f9;padding:48px 0 72px;min-height:75vh;color:#293344}.receipt-wrap{max-width:980px;margin:auto}.receipt-hero,.receipt-card{background:#fff;border:1px solid #e7eaf0;border-radius:22px;padding:26px;margin-bottom:18px}.receipt-hero{display:flex;gap:20px;align-items:center}.receipt-icon{width:64px;height:64px;flex-shrink:0;display:grid;place-items:center;border-radius:20px;font-size:30px;background:#fff4da;color:#9a6900}.receipt-icon.success{background:#e8f7ef;color:#17845b}.receipt-icon.failed{background:#ffedf0;color:#cf3652}.receipt-hero h1{font-size:1.4rem;font-weight:900;margin:0 0 10px}.receipt-hero p{margin:0;color:#6b7584;line-height:1.9}.receipt-grid{display:grid;grid-template-columns:1.5fr 1fr;gap:18px}.receipt-card h2{font-size:1rem;font-weight:850;margin:0 0 20px}.receipt-line{display:flex;justify-content:space-between;gap:16px;padding:12px 0;border-bottom:1px solid #eef0f4}.receipt-line:last-child{border:0}.receipt-line>span:first-child{color:#727d8e}.receipt-total{font-size:1.12rem;color:#17845b;font-weight:900}.receipt-product{display:flex;align-items:center;gap:14px;padding:16px 0;border-bottom:1px solid #eef0f4}.receipt-product img{width:64px;height:64px;border-radius:12px;object-fit:cover}.receipt-product-info{flex:1}.receipt-product a{color:inherit;text-decoration:none;font-weight:800}.receipt-muted{font-size:.82rem;color:#7b8491;margin-top:6px}.receipt-bank{background:#f8f9fc;border:1px solid #e5e9f0;border-radius:16px;padding:18px;line-height:2}.receipt-bank-number{font-size:1.3rem;font-weight:900;letter-spacing:2px;overflow-wrap:anywhere}.receipt-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px}.receipt-address{line-height:2;overflow-wrap:anywhere}.receipt-pill{display:inline-block;background:#f0f3f8;border-radius:30px;padding:5px 12px;font-size:.8rem}.receipt-steps{padding-right:20px;line-height:2.2;color:#687487}
@media(max-width:767px){.receipt-page{padding:24px 0 40px}.receipt-grid{grid-template-columns:1fr}.receipt-hero,.receipt-card{padding:20px}.receipt-hero{align-items:flex-start}.receipt-hero h1{font-size:1.1rem}.receipt-icon{width:48px;height:48px;font-size:24px}.receipt-product{flex-wrap:wrap}.receipt-line{font-size:.88rem}.receipt-actions .btn{flex:1}}
@media print{header,footer,nav,.receipt-actions{display:none!important}.receipt-page{padding:0;background:white}.receipt-grid{display:block}.receipt-card,.receipt-hero{break-inside:avoid}}
</style>
@endsection
@section('content')
@php
    $order = $transaction->payable;
    $manual = $transaction->gateway === 'manual';
    $success = $transaction->status === 'success';
    $pending = $transaction->status === 'pending';
    $title = $success ? 'پرداخت با موفقیت تأیید شد' : ($pending ? ($manual ? 'سفارش ثبت شد؛ در انتظار تأیید پرداخت' : 'پرداخت در انتظار بررسی است') : 'پرداخت تأیید نشد');
    $description = $success ? 'جزئیات پرداخت و وضعیت فعلی سفارش را در این صفحه می‌بینید.' : ($pending ? ($manual ? 'پس از واریز، رسید پرداخت را با کد سفارش برای پشتیبانی ارسال کنید. مدیر پس از بررسی، پرداخت را تأیید می‌کند.' : 'هنوز تأیید نهایی پرداخت دریافت نشده است. وضعیت سفارش را از حساب کاربری دنبال کنید.') : 'برای این تراکنش پرداخت موفقی ثبت نشده است. وضعیت سفارش را در حساب کاربری بررسی کنید.');
@endphp
<main class="receipt-page" dir="rtl"><div class="container"><div class="receipt-wrap">
    <section class="receipt-hero" aria-live="polite">
        <div class="receipt-icon {{ $success ? 'success' : ($pending ? '' : 'failed') }}"><i class="bi {{ $success ? 'bi-check2-circle' : ($pending ? 'bi-clock-history' : 'bi-x-circle') }}"></i></div>
        <div><h1>{{ $title }}</h1><p>{{ $description }}</p></div>
    </section>
    <div class="receipt-grid"><div>
        <section class="receipt-card">
            <h2>جزئیات سفارش <span class="receipt-pill">{{ $order->status_fa }}</span></h2>
            <div class="receipt-line"><span>کد سفارش</span><strong>{{ $order->tracking_code ?: $order->id }}</strong></div>
            @foreach($order->items as $item)
                <div class="receipt-product">
                    <img src="{{ $item->product?->firstMedia('main_image')?->full_url ?? asset('images/default-product.jpg') }}" alt="{{ $item->product?->name ?? 'محصول' }}">
                    <div class="receipt-product-info">
                        @if($item->product)<a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>@else<strong>محصول حذف‌شده</strong>@endif
                        <div class="receipt-muted">تعداد: {{ $item->quantity }} @foreach($item->attributeValues as $value) · {{ $value->attribute?->title ?? 'ویژگی' }}: {{ $value->display_value }} @endforeach</div>
                    </div><strong>{{ number_format($item->total_price) }} تومان</strong>
                </div>
            @endforeach
            <div class="receipt-line"><span>جمع کالاها</span><span>{{ number_format($order->total_price) }} تومان</span></div>
            <div class="receipt-line"><span>تخفیف</span><span>{{ number_format($order->discount_amount) }} تومان</span></div>
            <div class="receipt-line"><span>هزینه ارسال</span><span>{{ number_format($order->shipment?->shipping_cost ?? $order->shipping_cost ?? 0) }} تومان</span></div>
            <div class="receipt-line receipt-total"><span>مبلغ نهایی سفارش</span><span>{{ number_format($order->final_price) }} تومان</span></div>
        </section>
        <section class="receipt-card"><h2>گیرنده و ارسال</h2>
            <div class="receipt-line"><span>نام گیرنده</span><strong>{{ $order->fullname ?: '—' }}</strong></div>
            <div class="receipt-line"><span>شماره تماس</span><span dir="ltr">{{ $order->phone ?: '—' }}</span></div>
            <p class="receipt-address mt-3 mb-0">{{ $order->shipment?->shipping_address ?? $order->shipping_address ?? 'آدرس ثبت نشده است' }}</p>
            @if($order->shipment?->postal_code)<p class="receipt-muted">کد پستی: {{ $order->shipment->postal_code }}</p>@endif
            @if($order->shipment?->tracking_number)<div class="receipt-line"><span>کد رهگیری مرسوله</span><strong>{{ $order->shipment->tracking_number }}</strong></div>@endif
        </section>
    </div><aside>
        <section class="receipt-card"><h2>اطلاعات تراکنش</h2>
            <div class="receipt-line"><span>روش پرداخت</span><strong>{{ $manual ? 'کارت‌به‌کارت' : 'پرداخت اینترنتی' }}</strong></div>
            <div class="receipt-line"><span>وضعیت پرداخت</span><strong>{{ $success ? 'تأییدشده' : ($pending ? 'در انتظار تأیید' : 'ناموفق') }}</strong></div>
            <div class="receipt-line"><span>مبلغ تراکنش</span><strong>{{ number_format($transaction->amount) }} تومان</strong></div>
            <div class="receipt-line"><span>شماره تراکنش</span><span dir="ltr">{{ $transaction->our_token ?: $transaction->id }}</span></div>
            <div class="receipt-line"><span>تاریخ ثبت</span><span>{{ jdate($transaction->created_at)->format('Y/m/d H:i') }}</span></div>
            @if($transaction->paid_at)<div class="receipt-line"><span>تاریخ تأیید</span><span>{{ jdate($transaction->paid_at)->format('Y/m/d H:i') }}</span></div>@endif
            @if($transaction->ref_id)<div class="receipt-line"><span>کد مرجع</span><span>{{ $transaction->ref_id }}</span></div>@endif
        </section>
        @if($manual && $pending && !in_array($order->status, ['canceled', 'expired']))
        <section class="receipt-card"><h2>راهنمای کارت‌به‌کارت</h2>
            @if(site_setting('card_number'))
            <div class="receipt-bank"><div>{{ site_setting('Bank_name_and_relevant_card_number') }}</div><div class="receipt-bank-number" dir="ltr">{{ site_setting('card_number') }}</div><div>{{ site_setting('account_holder') }}</div></div>
            @endif
            @include('site.partials.receipt-contacts')
        </section>
        @endif
    </aside></div>
    <div class="receipt-actions"><a href="{{ route('account.orders.show', $order) }}" class="btn btn-dark rounded-pill px-4">جزئیات سفارش</a><a href="{{ route('account.index') }}" class="btn btn-outline-dark rounded-pill px-4">سفارش‌های من</a><a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">بازگشت به فروشگاه</a>@if($success)<button type="button" onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4">چاپ رسید</button>@endif</div>
</div></div></main>
@endsection
