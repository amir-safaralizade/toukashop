<?php

namespace App\Services\Auth;

class PasswordResetSession
{
    const KEY_PHONE = 'reset_phone';
    const KEY_TOKEN = 'reset_token';

    public function storePhone(string $phone): void
    {
        session()->put(self::KEY_PHONE, $phone);
    }

    public function getPhone(): ?string
    {
        return session()->get(self::KEY_PHONE);
    }

    public function forgetPhone(): void
    {
        session()->forget(self::KEY_PHONE);
    }

    public function storeToken(string $token): void
    {
        session()->put(self::KEY_TOKEN, $token);
    }

    public function getToken(): ?string
    {
        return session()->get(self::KEY_TOKEN);
    }

    public function forgetAll(): void
    {
        session()->forget([self::KEY_PHONE, self::KEY_TOKEN]);
    }
}
