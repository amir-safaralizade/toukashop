<?php

namespace App\Services\Sms\Providers;

use App\Services\Sms\SmsProviderInterface;
use Kavenegar;
use Illuminate\Support\Facades\Log;

class KavenegarProvider implements SmsProviderInterface
{
    public function sendText(string $to, string $message): bool
    {
        try {
            $response = Kavenegar::Send(config('services.kavenegar.sender'), $to, $message);
            return !empty($response);
        } catch (\Throwable $e) {
            Log::error("[Kavenegar] sendText failed", ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function sendTemplate(string $to, string $templateId, array $params): bool
    {
        try {
            $result = Kavenegar::VerifyLookup(
                $to,
                $params['code'] ?? '',
                $params['second'] ?? null,
                $params['third'] ?? null,
                $templateId
            );

            return !empty($result);
        } catch (\Throwable $e) {
            Log::error("[Kavenegar] sendTemplate failed", [
                'template' => $templateId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
