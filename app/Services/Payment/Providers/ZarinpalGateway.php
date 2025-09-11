<?php

namespace App\Services\Payment\Providers;

use App\Models\Order;
use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;
use App\Services\Payment\PaymentGatewayInterface;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class ZarinpalGateway implements PaymentGatewayInterface
{
    protected string $merchantId;

    public function __construct()
    {
        $this->merchantId = config('services.zarinpal.merchant_id');
    }

    public function request(PaymentRequestDTO $dto): string
    {
        $rial_amount = $dto->amount * 10;
        $response = Http::post('https://api.zarinpal.com/pg/v4/payment/request.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $rial_amount,
            'callback_url' => $dto->callbackUrl,
            'description' => $dto->description,
        ]);

        $data = $response->json();
        $order = Order::find($dto->orderId);

        $order->transactions()->create([
            'gateway' => 'zarinpal',
            'amount' => $dto->amount,
            'status' => 'pending',
            'description' => $dto->description,
            'raw_response' => $data,
            'our_token' => $dto->our_token,
            'Authority' => $data['data']['authority'],
            'request_ip' => get_client_ip()
        ]);

        if ($response->successful() && isset($data['data']['authority'])) {
            return 'https://www.zarinpal.com/pg/StartPay/' . $data['data']['authority'];
        }

        throw new \Exception($data['errors']['message'] ?? 'درخواست پرداخت با خطا مواجه شد.');
    }

    public function verify(PaymentVerifyDTO $dto): bool
    {
        $rialAmount = $dto->transaction->amount * 10;

        $response = Http::post('https://api.zarinpal.com/pg/v4/payment/verify.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $rialAmount,
            'authority' => $dto->transaction->Authority,
        ]);

        $data = $response->json('data') ?? [];

        $code = $data['code'] ?? 0;
        $status = $code >= 100 ? 'success' : 'failed';

        $paidAt = ($code > 100 && empty($dto->transaction->paid_at)) ? Carbon::now() : null;

        $dto->transaction->fill([
            'ref_id' => $data['ref_id'] ?? null,
            'card_hash' => $data['card_hash'] ?? null,
            'card_pan' => $data['card_pan'] ?? null,
            'fee_type' => $data['fee_type'] ?? null,
            'fee' => $data['fee'] ?? null,
            'status' => $status,
            'paid_at' => $paidAt,
            'verify_ip' => get_client_ip(),
        ]);
        $dto->transaction->save();

        if ($status == 'success') {
            return true;
        } else {
            return false;
        }
    }
}
