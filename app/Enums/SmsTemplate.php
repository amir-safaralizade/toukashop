<?php

namespace App\Enums;

enum SmsTemplate: string
{
    case ORDER_CONFIRMED = 'order_confirmed';
    case OTP_CODE = 'otp_code';

    public function id(): int
    {
        return match ($this) {
            SmsTemplate::ORDER_CONFIRMED => 868508,
            SmsTemplate::OTP_CODE => 654321,
        };
    }

    public static function resolveId(string $key): int
    {
        $enum = SmsTemplate::tryFrom($key);
        if (!$enum) {
            throw new \InvalidArgumentException("Invalid SMS template key: $key");
        }

        return $enum->id();
    }
}
