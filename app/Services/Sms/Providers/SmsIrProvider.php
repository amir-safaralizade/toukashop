<?php

namespace App\Services\Sms\Providers;

use App\Models\SmsLog;
use App\Services\Sms\SmsProviderInterface;
use App\Enums\SmsTemplate;
use Carbon\Carbon;
use Ipe\Sdk\Facades\SmsIr;
use Illuminate\Support\Facades\Http;

class SmsIrProvider implements SmsProviderInterface
{
    /**
     * Send plain text SMS message to a mobile number.
     */
    public function sendText(string $to, string $message): bool
    {
        $lineNumber = config('services.smsir.line_number');

        $response = SmsIr::bulkSend($lineNumber, $message, [$to]);

        SmsLog::create([
            'to'       => $to,
            'message'  => $message,
            'status'   => $response->status == 1 ? 'sent' : 'failed',
            'provider' => 'sms.ir',
            'error'    => $response->status == 1 ? null : json_encode([
                'message' => $response->message,
                'data'    => $response->data,
            ]),
            'sent_at'  => $response->status == 1 ? Carbon::now() : null,
        ]);

        return $response->status == 1;
    }

    /**
     * Send template SMS message using predefined template ID.
     *
     * @param string $to Recipient mobile number
     * @param string $templateKey Logical template key (e.g., 'order_confirmed')
     * @param array $parameters Template parameters as key-value array
     */
    public function sendTemplate(string $to, string $templateKey, array $parameters): bool
    {
        // Convert logical key to template ID
        $templateId = SmsTemplate::resolveId($templateKey);

        $verifyParams = [];
        foreach ($parameters as $name => $value) {
            $verifyParams[] = [
                'name'  => $name,
                'value' => $value,
            ];
        }

        $apiKey = config('services.smsir.api_key');
        if (!$apiKey) {
            throw new \RuntimeException('SMS.ir API key is not configured.');
        }

        $httpResponse = Http::withHeaders(['x-api-key' => $apiKey])
            ->acceptJson()
            ->connectTimeout(5)
            ->timeout(15)
            ->post('https://api.sms.ir/v1/send/verify', [
                'mobile' => $to,
                'templateId' => $templateId,
                'parameters' => $verifyParams,
            ]);

        $response = (object) [
            'status' => $httpResponse->successful() ? $httpResponse->json('status') : 0,
            'message' => $httpResponse->json('message'),
            'data' => $httpResponse->json('data'),
        ];

        SmsLog::create([
            'to'          => $to,
            'template_id' => $templateId,
            'parameters'  => $parameters,
            'status'      => $response->status == 1 ? 'sent' : 'failed',
            'provider'    => 'sms.ir',
            'error'       => $response->status == 1 ? null : json_encode([
                'message' => $response->message,
                'data'    => $response->data,
            ]),
            'sent_at'     => $response->status == 1 ? Carbon::now() : null,
        ]);

        return $response->status == 1;
    }
}
