<?php

namespace App\Services\Auth;

use App\Models\Admin;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class PasswordResetService
{
    protected PasswordResetSession $session;

    public function __construct(PasswordResetSession $session)
    {
        $this->session = $session;
    }

    /**
     * ارسال کد بازیابی به کاربر
     */
    public function sendCode(string $phone): void
    {
        $this->checkRateLimit($phone);

        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = Str::random(40);

        PasswordResetCode::create([
            'phone'      => $phone,
            'code'       => $code,
            'token'      => $token,
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->session->storeToken($token);
        $this->session->storePhone($phone);

        sms()->send($phone, 'reset_password_code', ['code' => $code]);

        activity()
            ->withProperties([
                'phone'      => $phone,
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
            ])
            ->log('ارسال کد بازیابی رمز عبور');

        RateLimiter::hit($this->throttleKey($phone), 600);
    }

    /**
     * تأیید کد بازیابی
     */
    public function verifyCode(string $phone, string $code): void
    {
        $token = $this->session->getToken();

        $resetCode = PasswordResetCode::where('phone', $phone)
            ->where('code', $code)
            ->where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$resetCode) {
            activity()
                ->withProperties([
                    'phone' => $phone,
                    'code'  => $code,
                    'ip_address' => get_client_ip(),
                    'user_agent' => get_user_agent(),
                ])
                ->log('تلاش ناموفق برای تأیید کد بازیابی');

            throw new \Exception('کد واردشده نامعتبر یا منقضی شده است.');
        }

        $resetCode->update(['used' => true]);

        $this->session->storePhone($phone);

        activity()
            ->withProperties([
                'phone' => $phone,
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
            ])
            ->log('تأیید موفق کد بازیابی رمز عبور');
    }

    /**
     * ریست کردن رمز عبور
     */
    public function resetPassword(string $phone, string $newPassword): void
    {
        $admin = Admin::where('phone', $phone)->first();

        if (!$admin) {
            activity()
                ->withProperties([
                    'phone' => $phone,
                    'ip_address' => get_client_ip(),
                    'user_agent' => get_user_agent(),
                ])
                ->log('تلاش ناموفق برای تغییر رمز عبور: کاربر یافت نشد');

            throw new \Exception('کاربر یافت نشد.');
        }

        $admin->update([
            'password' => Hash::make($newPassword),
        ]);

        PasswordResetCode::where('phone', $phone)->delete();
        $this->session->forgetAll();

        activity()
            ->causedBy($admin)
            ->withProperties([
                'phone' => $phone,
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
            ])
            ->log('تغییر موفق رمز عبور');
    }

    /**
     * بررسی محدودیت ارسال کد
     */
    protected function checkRateLimit(string $phone): void
    {
        $key = $this->throttleKey($phone);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw new \Exception("تعداد درخواست بیش از حد مجاز است. لطفاً پس از {$seconds} ثانیه دوباره تلاش کنید.");
        }
    }

    /**
     * تولید کلید محدودسازی
     */
    protected function throttleKey(string $phone): string
    {
        return 'password-reset:' . $phone . '|' . get_client_ip();
    }
}
