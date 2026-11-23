@if ($order && $order->items->isNotEmpty())
    @foreach ($order->items as $item)
        <div class="py-3 border-bottom d-flex gap-3 align-items-start">
            @if ($item->product)
                @php($image = $item->product->mediaFiles->firstWhere('group', 'main_image'))
                <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0">
                    @if ($image)
                        <img src="{{ $image->full_url }}" alt="{{ $image->alt ?: $item->product->name }}"
                            width="76" height="76" style="object-fit:contain;border:1px solid #edf0f1;border-radius:12px;background:#fff" />
                    @else
                        <span class="d-flex align-items-center justify-content-center rounded-3 bg-light" style="width:76px;height:76px" aria-label="تصویر موجود نیست"><i class="bi bi-image text-secondary fs-4"></i></span>
                    @endif
                </a>
            @endif
            <div class="flex-grow-1" style="min-width:0">
            @if ($item->product)
                <a class="text-reset text-decoration-none fw-bold" href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
            @else
                <strong>محصول حذف‌شده</strong>
            @endif
            <div class="d-flex justify-content-between mt-2 text-secondary">
                <span>{{ $item->quantity }} عدد</span>
                <span>{{ number_format($item->total_price) }} تومان</span>
            </div>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-between py-4 fw-bold"><span>جمع محصولات</span><span>{{ number_format($order->items->sum('total_price')) }} تومان</span></div>
    <a class="btn btn-primary w-100" href="{{ route('cart.mycart') }}">مشاهده سبد و ادامه خرید</a>
@else
    <div class="text-center py-5"><i class="bi bi-bag fs-1 text-secondary"></i><p class="mt-3">سبد خرید شما خالی است.</p><a href="{{ route('products.index') }}" class="btn btn-outline-primary">مشاهده محصولات</a></div>
@endif
