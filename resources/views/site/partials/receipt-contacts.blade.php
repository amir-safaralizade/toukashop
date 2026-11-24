@php
    $receiptSetting = \App\Models\Property::where('title', 'card_receipt_numbers')->first();
    $receiptNumbers = collect(preg_split('/[\s,،;]+/u', $receiptSetting ? (string) $receiptSetting->value : '09228059351', -1, PREG_SPLIT_NO_EMPTY))->filter(fn ($number) => preg_match('/^09[0-9]{9}$/', $number))->unique();
@endphp
<div class="receipt-contact-block" dir="rtl">
    <h3 style="font-size:1.05rem;font-weight:900;margin:20px 0 10px">ارسال رسید پرداخت</h3>
    <p style="line-height:2">لطفاً رسید و شماره سفارش خود را برای ما به این شماره‌ها در پیام‌رسان‌های بله، روبیکا، تلگرام یا واتساپ ارسال کنید.</p>
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin:16px 0" aria-label="پیام‌رسان‌های ارسال رسید">
        @foreach(['بله' => ['#12a99a', 'M7 12l3 3 7-7'], 'روبیکا' => ['#7563cf', 'M12 3l8 5v8l-8 5-8-5V8z M4 8l8 5 8-5 M12 13v8'], 'تلگرام' => ['#299ed7', 'M3 11l18-7-4 17-6-6-4 3 1-6 10-6-7 9'], 'واتساپ' => ['#25a66a', 'M5 18l-2 4 5-2a9 9 0 1 0-3-2 M8 7c0 5 4 9 9 9l1-3-3-1-1 1-3-3 1-1-1-3z']] as $messenger => [$color, $path])
            <span style="display:inline-flex;align-items:center;gap:7px;padding:9px 12px;border:1px solid #e3e7ed;background:#fff;border-radius:13px;color:#455164;font-size:.85rem;font-weight:700">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $path }}"/></svg>{{ $messenger }}
            </span>
        @endforeach
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:10px">
        @forelse($receiptNumbers as $receiptNumber)
            <strong dir="ltr" style="display:inline-block;background:#fff;border:1px solid #e1d5bc;border-radius:12px;padding:10px 18px;color:#493b26;font-size:1.25rem;letter-spacing:1px;user-select:all">{{ $receiptNumber }}</strong>
        @empty
            <span>برای ارسال رسید با پشتیبانی فروشگاه در ارتباط باشید.</span>
        @endforelse
    </div>
    <p style="margin:14px 0 0;font-size:.85rem;line-height:2">شماره سفارش شما: <strong>{{ $order->tracking_code ?: $order->id }}</strong>؛ پس از بررسی رسید، وضعیت پرداخت توسط مدیر به‌روزرسانی می‌شود.</p>
</div>
