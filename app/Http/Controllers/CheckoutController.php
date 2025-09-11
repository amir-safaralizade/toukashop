<?php

namespace App\Http\Controllers;

use App\Facades\Sms;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Payment\PaymentService;
use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;

class CheckoutController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * ثبت و نهایی‌سازی سفارش
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|integer|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'اطلاعات نامعتبر است', 'errors' => $validator->errors()], 422);
        }

        try {
            // 1. ساخت سفارش
            $order = $this->orderService->createOrder($request->cart, $request->shipping_address);

            // 2. اعمال کد تخفیف
            if ($request->filled('coupon_code')) {
                $this->orderService->applyCoupon($order, $request->coupon_code);
            }

            // 3. نهایی‌سازی سفارش
            $this->orderService->finalizeOrder($order);

            // 4. هدایت به درگاه پرداخت (الان فقط یک پاسخ نمایشی)
            return response()->json([
                'message' => 'سفارش با موفقیت ثبت شد.',
                'order_id' => $order->id,
                'final_price' => $order->final_price,
                'redirect_to' => route('payment.redirect', $order->id),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطا در ثبت سفارش', 'error' => $e->getMessage()], 500);
        }
    }


    public function redirectToGateway($order_id, $provider, PaymentService $paymentService)
    {
        $order = Order::where('id', $order_id)
            ->where('status', 'ready_to_pay')
            ->firstOrFail();

        $our_token = gen_transaction_id();

        $dto = new PaymentRequestDTO(
            orderId: $order->id,
            amount: $order->final_price,
            callbackUrl: route('payment.callback', $our_token),
            description: 'پرداخت سفارش #' . $order->id,
            our_token: $our_token,
            provider: $provider // ✅ مستقیم از route گرفته شده
        );

        $paymentUrl = $paymentService->pay($dto);
        return redirect($paymentUrl);
    }


    public function paymentCallback(Request $request, $our_token, PaymentService $paymentService)
    {
        $transaction = Transaction::where('our_token', $our_token)->firstOrfail();
        try {
            $dto = new PaymentVerifyDTO(
                transaction: $transaction,
                requestData: $request->all()
            );
            if (!empty($transaction->verify_ip)) {
                return redirect(route('cart.factor-status', encrypt($transaction->id)));
            }
            $success = $paymentService->verify($dto);

            if ($success) {
                $payable = $transaction->payable;
                if (get_class($payable) == Order::class) {
                    $order = $payable;
                    app(OrderService::class)->markAsPaid($order);
                    return redirect(route('cart.factor-status', encrypt($transaction->id)));
                }
            } else {
                return redirect(route('cart.factor-status', encrypt($transaction->id)));
            }
        } catch (\Exception $e) {
            return redirect(route('cart.factor-status', encrypt($transaction->id)));
        }
    }
}
