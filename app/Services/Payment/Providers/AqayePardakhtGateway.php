<?php

namespace App\Services\Payment\Providers;

use App\Models\Order;
use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;
use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
class AqayePardakhtGateway implements PaymentGatewayInterface
{
    // Base endpoints
    private string $apiBase = 'https://panel.aqayepardakht.ir/api/v2/';
    private string $startBase = 'https://panel.aqayepardakht.ir/startpay/';

    /**
     * Create transaction and return redirect URL to payment page
     */
    public function request(PaymentRequestDTO $dto): string
    {
        // AP docs: amount is in Toman (DO NOT multiply by 10)
        $payload = [
            'pin'        => config('payment.AqayePardakht.pin'),
            'amount'     => (int) $dto->amount,
            'callback'   => $dto->callbackUrl,
            // Optional fields:
            'invoice_id' => (string)($dto->orderId ?? ''),
            'description'=> $dto->description ?? null,
            // 'card_number' => 'XXXXXXXXXXXXXXXX', // if you want to lock card
            // 'mobile'      => $dto->mobile ?? null,
            // 'email'       => $dto->email ?? null,
        ];

        $res = $this->postJson($this->apiBase.'create', $payload);

        if ($res && ($res->status ?? null) === 'success' && !empty($res->transid)) {
            $transId = (string)$res->transid;

            // persist a pending transaction
            $order = Order::findOrFail($dto->orderId);
            $order->transactions()->create([
                'gateway'      => 'AqayePardakht',
                'amount'       => (int) $dto->amount, // Toman
                'status'       => 'pending',
                'description'  => $dto->description,
                'raw_response' => null,
                'our_token'    => $dto->our_token ?? null,
                // Keep naming consistent with your schema:
                'Authority'    => $transId, // store gateway transid here
                'request_ip'   => get_client_ip(),
            ]);

            // Sandbox or production start URL
            $sandbox = (bool) config('payment.aqpay.sandbox', false);
            $startUrl = $this->startBase . ($sandbox ? ('sandbox/'.$transId) : $transId);

            return $startUrl;
        }

        // You can throw or return a route/back; here we'll throw to be caught by caller layer.
        throw new \RuntimeException('خطا در اتصال به درگاه آقای پرداخت.');
    }

    /**
     * Verify transaction after callback
     */
    public function verify(PaymentVerifyDTO $dto): bool
    {
        Log::info('afaionfgosengsneg');
        // In AP callback you receive: transid, cardnumber, tracking_number, status(1|0), etc.
        $transId   = $dto->requestData['transid'] ?? null;
        $statusStr = $dto->requestData['status']  ?? null; // "1" or "0" (string or int)

        $trx = $dto->transaction;

        // TransId mismatch
        if (empty($transId) || $trx->Authority !== $transId) {
            return false;
        }

        // If gateway says status == 0, you may skip verify and mark failed
        if ((string)$statusStr === "0") {
            $trx->fill([
                'status'    => ($trx->status === 'success') ? 'success' : 'failed',
                'verify_ip' => get_client_ip(),
            ])->save();
            return false;
        }

        $maxAttempts = 3;
        $attempt = 0;

        // card & ref (if sent in callback) — store if missing
        $callbackCard = $dto->requestData['cardnumber'] ?? null;
        $callbackRef  = $dto->requestData['tracking_number'] ?? null;

        while ($attempt < $maxAttempts) {
            $attempt++;

            try {
                $payload = [
                    'pin'     => config('payment.AqayePardakht.pin'),
                    'amount'  => (int) $trx->amount,  // Toman
                    'transid' => $transId,
                ];

                $res = $this->postJson($this->apiBase.'verify', $payload);

                // Response:
                // success -> {"status":"success","code":"1"}
                // already verified -> {"status":"error","code":"2"} (docs say error but meaning: already verified)
                $status = $res->status ?? null;
                $code   = (string)($res->code ?? '');

                if ($status === 'success' && $code === '1') {
                    $patch = [
                        ...($trx->status !== 'success' ? ['status' => 'success'] : []),
                        ...(empty($trx->paid_at) ? ['paid_at' => Carbon::now()] : []),
                        ...(empty($trx->verify_ip) ? ['verify_ip' => get_client_ip()] : []),
                    ];

                    // Prefer callback card/ref if verify API doesn't return them
                    if ($callbackCard && empty($trx->card_pan)) {
                        $patch['card_pan'] = $callbackCard;
                    }
                    if ($callbackRef && empty($trx->ref_id)) {
                        $patch['ref_id'] = $callbackRef;
                    }

                    if (!empty($patch)) {
                        $trx->fill($patch)->save();
                    }
                    return true;
                }

                // Code 2: already verified before -> treat as success (idempotent)
                if ($code === '2') {
                    $patch = [
                        ...($trx->status !== 'success' ? ['status' => 'success'] : []),
                        ...(empty($trx->paid_at) ? ['paid_at' => Carbon::now()] : []),
                        ...(empty($trx->verify_ip) ? ['verify_ip' => get_client_ip()] : []),
                    ];
                    if ($callbackCard && empty($trx->card_pan)) {
                        $patch['card_pan'] = $callbackCard;
                    }
                    if ($callbackRef && empty($trx->ref_id)) {
                        $patch['ref_id'] = $callbackRef;
                    }
                    if (!empty($patch)) {
                        $trx->fill($patch)->save();
                    }
                    return true;
                }

                // Any other code: mark failed (but do not overwrite success)
                $trx->fill([
                    'status'    => ($trx->status === 'success') ? 'success' : 'failed',
                    'verify_ip' => get_client_ip(),
                ])->save();
                return false;

            } catch (\Throwable $e) {
                if ($attempt >= $maxAttempts) {
                    // final failure — do not overwrite success
                    $trx->fill([
                        'status'    => ($trx->status === 'success') ? 'success' : 'failed',
                        'verify_ip' => get_client_ip(),
                    ])->save();
                    return false;
                }
                usleep(200_000); // 200ms backoff
            }
        }

        return false;
    }

    /**
     * Basic JSON POST helper using cURL
     */
    private function postJson(string $url, array $payload): ?\stdClass
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
        ]);
        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($raw === false || !empty($err)) {
            throw new \RuntimeException('AqayePardakht request failed: '.$err);
        }
        $json = json_decode($raw);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON from AqayePardakht.');
        }
        return $json;
    }
}
