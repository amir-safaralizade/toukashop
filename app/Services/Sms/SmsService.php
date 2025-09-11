<?php

namespace App\Services\Sms;

use App\Services\Sms\Providers\SmsIrProvider;
use App\Enums\SmsTemplate;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Facades\Agent;

class SmsService
{
    protected SmsProviderInterface $provider;

    /**
     * @param SmsProviderInterface|null $provider
     */
    public function __construct(SmsProviderInterface $provider = null)
    {
        $this->provider = $provider ?? app(SmsIrProvider::class);
    }

    /**
     * Send a simple text SMS
     */
    public function sendText(string $to, string $message): bool
    {
        return $this->provider->sendText($to, $message);
    }

    /**
     * Send an SMS with a predefined template and variables
     */
    public function sendTemplate(string $to, SmsTemplate $template, array $params): bool
    {
        return $this->provider->sendTemplate($to, $template->value, $params);
    }

    public function send(string $to, SmsTemplate|string $templateOrText, array $params = []): bool
    {
        $result = false;

        if ($templateOrText instanceof SmsTemplate) {
            $result = $this->sendTemplate($to, $templateOrText, $params);
        } elseif (empty($params)) {
            $result = $this->sendText($to, $templateOrText);
        } else {
            // Fallback: A little conservative
            $result = $this->sendTemplate($to, SmsTemplate::tryFrom($templateOrText) ?? SmsTemplate::RESET_PASSWORD, $params);
        }

        activity()
            ->withProperties([
                'phone' => $to,
                'template' => $templateOrText instanceof SmsTemplate ? $templateOrText->value : null,
                'message' => is_string($templateOrText) ? $templateOrText : null,
                'params' => $params,
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
                'success' => $result,
                'provider' => get_class($this->provider),
            ])
            ->log('SMS sent');

        return $result;
    }
}
