<?php

namespace App\Services\Sms\Providers;

use App\Models\SmsLog;
use App\Services\Sms\SmsProviderInterface;
use App\Enums\SmsTemplate;
use Carbon\Carbon;
use Ipe\Sdk\Facades\SmsIr;

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

        $response = SmsIr::verifySend($to, $templateId, $verifyParams);

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
