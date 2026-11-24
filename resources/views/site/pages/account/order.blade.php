@extends('layout.app')

@section('title', 'جزئیات سفارش')
@section('styles')
<style>
    .order-page{min-height:70vh;padding:42px 0 70px;background:#f7f8fa}.order-panel{background:#fff;border:1px solid #e6eaed;border-radius:20px;padding:22px;margin-bottom:18px}.order-top{display:flex;justify-content:space-between;gap:15px;align-items:center}.order-top h1{font-size:1.35rem;font-weight:950;margin:0}.order-badge{padding:7px 12px;border-radius:999px;background:#eef8f5;color:#19765b;font-weight:850}.order-product{display:grid;grid-template-columns:78px 1fr auto;gap:14px;align-items:center;padding:15px 0;border-bottom:1px solid #eef0f2}.order-product:last-child{border:0}.order-product img{width:78px;height:68px;border-radius:13px;object-fit:cover;background:#f1f2f3}.order-product h2{font-size:.95rem;font-weight:900;margin:0 0 6px}.order-attrs{color:#747f89;font-size:.8rem}.order-total{display:flex;justify-content:space-between;font-weight:950;font-size:1.08rem}.order-address{color:#606b75;line-height:2}@media(max-width:575px){.order-product{grid-template-columns:62px 1fr}.order-product img{width:62px;height:58px}.order-product>strong{grid-column:2}.order-top{align-items:flex-start;flex-direction:column}}
.transfer-notice{background:linear-gradient(135deg,#fff8e8,#fffdf7);border:2px solid #efc368;border-radius:24px;padding:28px;margin-bottom:26px;box-shadow:0 10px 32px #a9751510;color:#513b1d}.transfer-heading{display:flex;align-items:flex-start;gap:14px}.transfer-symbol{display:grid;place-items:center;flex-shrink:0;width:52px;height:52px;border-radius:16px;background:#fce4ac;color:#80520b;font-size:26px}.transfer-heading h2{font-size:1.25rem;font-weight:950;line-height:1.8;margin:0 0 8px}.transfer-heading p,.transfer-receipt p{line-height:2;margin:0;color:#725e40}.transfer-amount{display:flex;justify-content:space-between;align-items:center;gap:12px;margin:22px 0;padding:16px 18px;border-radius:14px;background:#fff0ce}.transfer-amount strong{font-size:1.5rem;font-weight:950}.transfer-amount small{font-size:.9rem}.transfer-destination{background:#fff;border:1px solid #ebdfc9;border-radius:16px;padding:20px;line-height:2.1;text-align:center}.transfer-card-number{display:block;font-size:clamp(1.2rem,4vw,1.85rem);letter-spacing:2px;color:#243349;margin:10px 0;overflow-wrap:anywhere;user-select:all}.transfer-receipt{margin-top:24px}.transfer-receipt h3{font-size:1.05rem;font-weight:900}.transfer-phone{display:inline-block;color:#513b1d;font-size:1.8rem;font-weight:950;text-decoration:none;letter-spacing:1px;margin:10px 0}.transfer-actions{display:flex;flex-wrap:wrap;gap:10px}.transfer-footnote{margin:20px 0 0;padding-top:16px;border-top:1px solid #eadab9;font-size:.85rem;line-height:2;color:#806745}@media(max-width:575px){.transfer-notice{padding:20px}.transfer-heading h2{font-size:1.05rem}.transfer-amount{align-items:flex-start;flex-direction:column}.transfer-actions .btn{width:100%}}
</style>
@endsection

@section('content')
<main class="order-page"><div class="container" style="max-width:850px">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($order->payment_method === 'card' && in_array($order->status, ['ready_to_pay', 'need_admin_approval']))
        <section class="transfer-notice" role="note" aria-labelledby="transfer-title" dir="rtl">
            <div class="transfer-heading"><span class="transfer-symbol"><i class="bi bi-credit-card-2-front"></i></span><div><h2 id="transfer-title">برای تکمیل سفارش، پرداخت کارت‌به‌کارت را انجام دهید</h2><p>سفارش شما ثبت شده، اما پرداخت آن هنوز تأیید نشده است.</p></div></div>
            <div class="transfer-amount"><span>مبلغ قابل پرداخت</span><strong>{{ number_format($order->final_price) }} <small>تومان</small></strong></div>
            @if(site_setting('card_number'))
                <div class="transfer-destination"><span>مبلغ را به این شماره کارت واریز کنید</span><strong class="transfer-card-number" dir="ltr">{{ site_setting('card_number') }}</strong><div>{{ site_setting('Bank_name_and_relevant_card_number') }}</div><div>به نام: <strong>{{ site_setting('account_holder') }}</strong></div></div>
            @else
                <p class="mt-3">برای دریافت شماره کارت با پشتیبانی تماس بگیرید.</p>
            @endif
            @include('site.partials.receipt-contacts')
            <p class="transfer-footnote">اگر قبلاً واریز کرده‌اید، دوباره پرداخت نکنید؛ رسید را ارسال کنید و منتظر تأیید بمانید.</p>
        </section>
    @endif
    <a href="{{ route('account.index') }}" class="text-decoration-none text-muted d-inline-block mb-3"><i class="bi bi-arrow-right"></i> بازگشت به حساب</a>
    <section class="order-panel order-top"><div><h1>سفارش #{{ $order->id }}</h1><small class="text-muted">{{ jdate($order->created_at)->format('Y/m/d H:i') }}</small></div><span class="order-badge">{{ $order->status_fa }}</span></section>
    <section class="order-panel">
        @foreach($order->items as $item)
            @php($image = $item->product?->mediaFiles?->firstWhere('group', 'main_image'))
            <article class="order-product">
                @if($item->product)<a href="{{ route('products.show', $item->product->slug) }}"><img src="{{ $image?->full_url ?? asset('images/default-product.jpg') }}" alt="{{ $item->product->name }}"></a>@else<img src="{{ asset('images/default-product.jpg') }}" alt="محصول حذف‌شده">@endif
                <div><h2>@if($item->product)<a class="text-reset text-decoration-none" href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>@else محصول حذف‌شده @endif</h2><div class="order-attrs">تعداد: {{ $item->quantity }} @foreach($item->attributeValues as $value) · {{ $value->attribute->title ?? $value->attribute->name }}: {{ $value->display_value }} @endforeach</div></div>
                <strong>{{ number_format($item->total_price) }} تومان</strong>
            </article>
        @endforeach
    </section>
    @if($order->shipment)<section class="order-panel order-address"><strong>اطلاعات ارسال</strong><br>{{ $order->shipment->shipping_address }}<br>کد پستی: {{ $order->shipment->postal_code }} @if($order->shipment->tracking_number)<br>کد رهگیری: {{ $order->shipment->tracking_number }}@endif</section>@endif
    <section class="order-panel order-total"><span>مبلغ نهایی</span><span>{{ number_format($order->final_price) }} تومان</span></section>
    <section class="order-panel">
        <h2 class="h6 fw-bold mb-3">سوابق پرداخت</h2>
        @forelse($order->transactions->sortByDesc('id') as $payment)
            <div class="d-flex flex-wrap justify-content-between align-items-center py-3 border-bottom" style="gap:12px">
                <div><strong>{{ $payment->gateway === 'manual' ? 'کارت‌به‌کارت' : 'پرداخت اینترنتی' }}</strong><div class="order-attrs mt-1">{{ jdate($payment->created_at)->format('Y/m/d H:i') }} · {{ $payment->status === 'success' ? 'تأییدشده' : ($payment->status === 'pending' ? 'در انتظار تأیید' : 'ناموفق') }}</div></div>
                <strong>{{ number_format($payment->amount) }} تومان</strong>
                <a class="btn btn-sm btn-outline-dark rounded-pill" href="{{ route('cart.factor-status', encrypt($payment->id)) }}">مشاهده رسید</a>
            </div>
        @empty
            <p class="text-muted mb-0">تراکنشی برای این سفارش ثبت نشده است.</p>
        @endforelse
    </section>
</div></main>
@endsection
