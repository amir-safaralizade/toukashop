@extends('layout.app')

@section('title', 'جزئیات سفارش')
@section('styles')
<style>
    .order-page{min-height:70vh;padding:42px 0 70px;background:#f7f8fa}.order-panel{background:#fff;border:1px solid #e6eaed;border-radius:20px;padding:22px;margin-bottom:18px}.order-top{display:flex;justify-content:space-between;gap:15px;align-items:center}.order-top h1{font-size:1.35rem;font-weight:950;margin:0}.order-badge{padding:7px 12px;border-radius:999px;background:#eef8f5;color:#19765b;font-weight:850}.order-product{display:grid;grid-template-columns:78px 1fr auto;gap:14px;align-items:center;padding:15px 0;border-bottom:1px solid #eef0f2}.order-product:last-child{border:0}.order-product img{width:78px;height:68px;border-radius:13px;object-fit:cover;background:#f1f2f3}.order-product h2{font-size:.95rem;font-weight:900;margin:0 0 6px}.order-attrs{color:#747f89;font-size:.8rem}.order-total{display:flex;justify-content:space-between;font-weight:950;font-size:1.08rem}.order-address{color:#606b75;line-height:2}@media(max-width:575px){.order-product{grid-template-columns:62px 1fr}.order-product img{width:62px;height:58px}.order-product>strong{grid-column:2}.order-top{align-items:flex-start;flex-direction:column}}
</style>
@endsection

@section('content')
<main class="order-page"><div class="container" style="max-width:850px">
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
</div></main>
@endsection
