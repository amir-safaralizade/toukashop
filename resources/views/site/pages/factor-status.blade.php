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
            --success: #4caf50;
            --danger: #f44336;
        }

        .transaction-container {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(179, 153, 212, 0.1);
            margin: 2rem auto;
            max-width: 900px;
        }

        .transaction-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .transaction-title {
            font-family: "Dancing Script", cursive;
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .transaction-status {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .status-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .status-failed {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .transaction-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .icon-success {
            color: var(--success);
        }

        .icon-failed {
            color: var(--danger);
        }

        .transaction-details {
            background-color: var(--cream);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-row {
            display: flex;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--light-purple);
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            flex: 0 0 150px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .detail-value {
            flex: 1;
            color: var(--text-dark);
        }

        .order-summary {
            background-color: var(--cream);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .order-items {
            margin-top: 1rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(179, 153, 212, 0.2);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-left: 1rem;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .item-attributes {
            font-size: 0.9rem;
            color: var(--purple);
        }

        .item-price {
            font-weight: 600;
            color: var(--purple);
            min-width: 100px;
            text-align: left;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--pink), var(--purple));
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 153, 212, 0.3);
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: var(--purple);
            border: 2px solid var(--purple);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background-color: var(--light-purple);
            color: var(--purple);
        }

        @media (max-width: 768px) {
            .transaction-container {
                padding: 1.5rem;
            }

            .transaction-title {
                font-size: 2rem;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                margin-bottom: 0.5rem;
            }

            .order-item {
                flex-wrap: wrap;
            }

            .item-price {
                width: 100%;
                margin-top: 1rem;
                text-align: right;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary, .btn-outline {
                width: 100%;
                text-align: center;
            }
        }


        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .icon-pending {
            color: #ffc107;
        }

    </style>
@endsection

@section('content')
    <main class="py-5" style="background-color: var(--cream);">
        <div class="transaction-container">
            <div class="transaction-header">
                @if($transaction->gateway === 'manual' && $transaction->status === 'pending')
                    <div class="transaction-icon icon-pending">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="transaction-status status-pending">
                        در انتظار تایید پرداخت
                    </div>
                    <h1 class="transaction-title">منتظر تایید پرداخت کارت‌به‌کارت </h1>
                    <p>
                        درخواست شما برای پرداخت از طریق کارت‌به‌کارت با موفقیت ثبت شد.
                        لطفاً پس از انجام واریز، رسید پرداخت را به همراه شماره سفارش خود
                        <span class="text-success">{{'('.$transaction->payable->tracking_code.')'}}</span>
                        برای
                        تیم پشتیبانی ارسال نمایید.
                    </p>
                    <p class="btn btn-outline-primary">0905-362-1387</p>
                    <p class="btn btn-outline-primary"> 0992-080-5054</p>
                    <p>
                        در صورتی که هنوز مبلغ را واریز نکرده‌اید، لطفاً در اسرع وقت پرداخت را انجام دهید و سپس رسید را
                        از طریق تلگرام یا سایر پیام رسان ها برای ما ارسال کنید تا سفارش شما تایید و پردازش شود.
                    </p>

                @elseif($transaction->status === 'success')
                    <div class="transaction-icon icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="transaction-status status-success">
                        پرداخت موفق
                    </div>
                    <h1 class="transaction-title">سفارش شما با موفقیت ثبت شد!</h1>
                    <p>از خرید و اعتماد شما متشکریم.</p>
                @else
                    <div class="transaction-icon icon-failed">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="transaction-status status-failed">
                        پرداخت ناموفق
                    </div>
                    <h1 class="transaction-title">پرداخت انجام نشد</h1>
                    <p>متأسفانه پرداخت شما با مشکل مواجه شد. می‌توانید مجدداً تلاش کنید.</p>
                @endif

            </div>

            <div class="transaction-details">
                <h4 style="color: var(--purple); margin-bottom: 1.5rem;">جزئیات تراکنش</h4>

                <div class="detail-row">
                    <div class="detail-label">شماره تراکنش:</div>
                    <div class="detail-value">{{ $transaction->our_token ?? '-' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">تاریخ تراکنش:</div>
                    <div class="detail-value">{{ $transaction->created_at->format('Y/m/d H:i') }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">وضعیت تراکنش:</div>
                    <div class="detail-value">
                        @if($transaction->gateway === 'manual' && $transaction->status === 'pending')
                            <span style="color: #ffc107;">در انتظار تایید</span>
                        @elseif($transaction->status === 'success')
                            <span style="color: var(--success);">موفق</span>
                        @else
                            <span style="color: var(--danger);">ناموفق</span>
                        @endif
                    </div>
                </div>


                <div class="detail-row">
                    <div class="detail-label">مبلغ تراکنش:</div>
                    <div class="detail-value">{{ number_format($transaction->amount) }} تومان</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">روش پرداخت:</div>
                    <div class="detail-value">
                        {{ $transaction->gateway === 'manual' ? 'کارت به کارت' : 'درگاه آنلاین' }}
                    </div>
                </div>

                @php($order = $transaction->payable)
                @if($transaction->status === 'success')
                    <div class="detail-row">
                        <div class="detail-label">شماره سفارش:</div>
                        <div class="detail-value">{{ $order->tracking_code }}</div>
                    </div>
                @endif
            </div>

            <div class="order-summary">
                <h4 style="color: var(--purple); margin-bottom: 1.5rem;">جزئیات سفارش</h4>

                <div class="order-items">
                    @foreach($order->items as $item)
                        <div class="order-item">
                            <img src="{{ $item->product->firstMedia('main_image')->full_url }}"
                                 alt="{{ $item->product->name }}"
                                 class="item-image">
                            <div class="item-info">
                                <h5 class="item-name">{{ $item->product->name }}</h5>
                                <p class="item-attributes">
                                    @foreach($item->attributeValues as $attrValue)
                                        {{ $attrValue->attribute->name }}: {{ $attrValue->value }}
                                        @if(!$loop->last)
                                            |
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <div class="item-price">
                                {{ number_format($item->total_price) }} تومان
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="detail-row">
                    <div class="detail-label">جمع کل:</div>
                    <div class="detail-value">{{ number_format($order->total_price) }} تومان</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">تخفیف:</div>
                    <div class="detail-value">{{ number_format($order->discount_amount) }} تومان</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">هزینه ارسال:</div>
                    <div class="detail-value">{{ number_format($order->shipment->shipping_cost ?? 0) }} تومان</div>
                </div>

                <div class="detail-row" style="border-bottom: none;">
                    <div class="detail-label">مبلغ قابل پرداخت:</div>
                    <div class="detail-value" style="font-weight: 600; color: var(--purple);">
                        {{ number_format($order->final_price + ($order->shipment->shipping_cost ?? 0)) }} تومان
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                @if($transaction->status === 'success')
                    <a href="{{ route('page.orderTracking') }}" class="btn-primary">
                        <i class="bi bi-truck"></i> پیگیری سفارش
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-outline">
                        <i class="bi bi-arrow-left"></i> بازگشت به فروشگاه
                    </a>
                @endif
            </div>
        </div>
    </main>
@endsection
