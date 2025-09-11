<?php

namespace App\Services\Payment\Providers;

use App\Models\Order;
use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;
use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Support\Carbon;

class ZibalGateway implements PaymentGatewayInterface
{
    public function request(PaymentRequestDTO $dto): string
    {
        $parameters = array(
            "merchant" => config('payment.zibal.merchantId'),
            "callbackUrl" => $dto->callbackUrl,
            "amount" => $dto->amount * 10,
            "orderId" => $dto->orderId,
        );

        $response = $this->postToZibal('request/lazy', $parameters);
        if ($response && $response->result && $response->result == 100) {
            $trackId = $response->trackId;
            $order = Order::findOrFail($dto->orderId);
            $order->transactions()->create([
                'gateway' => 'zibal',
                'amount' => $dto->amount,
                'status' => 'pending',
                'description' => $dto->description,
                'raw_response' => null,
                'our_token' => $dto->our_token ?? null,
                'Authority' => $trackId,
                'request_ip' => get_client_ip(),
            ]);
            $startGateWayUrl = "https://gateway.zibal.ir/start/{$trackId}";
            return $startGateWayUrl;
        } else {
            return redirect()->back()->with('error', 'خطا در اتصال به درگاه بانکی لطفا بعدا امتحان کنید');
        }
    }

    public function verify(PaymentVerifyDTO $dto): bool
    {
        $trackId = $dto->requestData['trackId'];
        $trx = $dto->transaction;
        if ($trx->Authority != $trackId) {
            return false;
        }

        try {
            $maxAttempts = 3;
            $attempt = 0;
            $success = false;

            while ($attempt < $maxAttempts && !$success) {
                $attempt++;

                try {
                    $parameters = [
                        "merchant" => config('payment.zibal.merchantId'),
                        "trackId"  => $trackId,
                    ];

                    $response = $this->postToZibal('verify', $parameters);

                    // Extract optional fields (names from Zibal response)
                    $cardNumber = $response->cardNumber ?? null;
                    $refNumber  = $response->refNumber  ?? null;

                    if ($response->result == 100) {
                        // Fresh success: set success fields. But still avoid overwriting existing non-empty fields.
                        $patch = [
                            // set status only if not already success
                            ...($trx->status !== 'success' ? ['status' => 'success'] : []),

                            // set paid_at only if empty
                            ...(empty($trx->paid_at) ? ['paid_at' => Carbon::now()] : []),

                            // set verify_ip only if empty (do NOT overwrite original)
                            ...(empty($trx->verify_ip) ? ['verify_ip' => get_client_ip()] : []),
                        ];

                        // Persist card/ref only if present and not already stored
                        if ($cardNumber && empty($trx->card_number)) {
                            $patch['card_pan'] = $cardNumber;
                        }
                        if ($refNumber && empty($trx->ref_number)) {
                            $patch['ref_id'] = $refNumber;
                        }

                        if (!empty($patch)) {
                            $trx->fill($patch)->save();
                        }

                        $success = true;
                    } elseif ($response->result == 201) {
                        // Already verified before: DO NOT overwrite existing values.
                        // Only fill missing fields (status if not success, paid_at if empty, verify_ip if empty),
                        // and also cardNumber/refNumber if provided and not saved yet.
                        $patch = [
                            ...($trx->status !== 'success' ? ['status' => 'success'] : []),
                            ...(empty($trx->paid_at) ? ['paid_at' => Carbon::now()] : []),
                            ...(empty($trx->verify_ip) ? ['verify_ip' => get_client_ip()] : []),
                        ];

                        if ($cardNumber && empty($trx->card_number)) {
                            $patch['card_pan'] = $cardNumber;
                        }
                        if ($refNumber && empty($trx->ref_number)) {
                            $patch['ref_id'] = $refNumber;
                        }

                        if (!empty($patch)) {
                            $trx->fill($patch)->save();
                        }

                        $success = true;
                    } else {
                        $success = false;
                        $trx->fill([
                            'status' => 'failed',
                            'verify_ip' => get_client_ip()
                        ])->save();
                        break;
                    }
                } catch (\Exception $e) {
                    if ($attempt >= $maxAttempts) {
                        // final failure, do NOT overwrite existing fields except status/verify_ip minimally
                        $patch = [
                            ...($trx->status !== 'success' ? ['status' => 'failed'] : []),
                            ...(empty($trx->verify_ip) ? ['verify_ip' => get_client_ip()] : []),
                        ];
                        if (!empty($patch)) {
                            $trx->fill($patch)->save();
                        }
                        return false;
                    }
                    // small backoff before next try
                    usleep(200000); // 200ms
                }
            }
            return $success;
        } catch (\Exception $e) {
            $trx->fill([
                'status'    => 'failed',
                'verify_ip' => get_client_ip(),
            ])->save();
            return false;
        }
    }

    private function postToZibal($path, $parameters)
    {
        $url = 'https://gateway.zibal.ir/' . $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }
}
