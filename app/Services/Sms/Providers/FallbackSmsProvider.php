<?php

namespace App\Services\Sms\Providers;

use App\Services\Sms\SmsProviderInterface;
use Illuminate\Support\Facades\Log;

class FallbackSmsProvider implements SmsProviderInterface
{
    /**
     * @var SmsProviderInterface[]
     */
    protected array $providers;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function sendText(string $to, string $message): bool
    {
        foreach ($this->providers as $provider) {
            try {
                if ($provider->sendText($to, $message)) {
                    Log::info("[SMS ✅] sent by " . get_class($provider));
                    return true;
                }
            } catch (\Throwable $e) {
                Log::warning("[SMS ❌] failed by " . get_class($provider), [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return false;
    }

    public function sendTemplate(string $to, string $templateId, array $params): bool
    {
        foreach ($this->providers as $provider) {
            try {
                if ($provider->sendTemplate($to, $templateId, $params)) {
                    Log::info("[SMS ✅] template sent by " . get_class($provider));
                    return true;
                }
            } catch (\Throwable $e) {
                Log::warning("[SMS ❌] template failed by " . get_class($provider), [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return false;
    }
}
