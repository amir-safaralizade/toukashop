<?php

namespace App\Services\Sms;

interface SmsProviderInterface
{
    public function sendText(string $to, string $message): bool;

    /**
     *
     * @param string $to
     * @param string $templateId
     * @param array $parameters
     * @return bool
     */
    public function sendTemplate(string $to, string $templateId, array $parameters): bool;
}
