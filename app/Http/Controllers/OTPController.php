<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class OTPController extends Controller
{
    public function send(Request $request)
    {
        $phone = $this->normalizeDigits($request->input('phone'));
        $request->merge(['phone' => $phone]);
        $data = $request->validate([
            'phone' => ['required', 'regex:/^09\d{9}$/'],
            'purpose' => ['required', 'in:authenticate'],
        ], ['phone.regex' => 'شماره همراه باید با 09 شروع شود و 11 رقم باشد.']);

        $key = 'otp:' . $phone . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json([
                'message' => 'درخواست‌های شما بیش از حد مجاز است. لطفاً کمی بعد دوباره تلاش کنید.',
                'retry_after' => RateLimiter::availableIn($key),
            ], 429);
        }

        VerificationCode::where('phone', $phone)->where('verified', false)->delete();
        $otp = VerificationCode::generate($phone);

        if (app()->environment(['local', 'testing']) || config('services.sms_fake_mode')) {
            RateLimiter::hit($key, 600);

            return response()->json([
                'message' => 'حالت تست فعال است؛ پیامک واقعی ارسال نشد.',
                'expires_in' => 180,
                'debug_code' => $otp->code,
            ]);
        }

        try {
            $sent = sms()->sendText($phone, "کد ورود توکا: {$otp->code}\nاین کد تا ۳ دقیقه معتبر است.");
            if (!$sent) {
                throw new \RuntimeException('SMS provider returned an unsuccessful response.');
            }
            RateLimiter::hit($key, 600);

            return response()->json(['message' => 'کد تأیید برای شما پیامک شد.', 'expires_in' => 180]);
        } catch (\Throwable $exception) {
            $otp->delete();
            Log::error('OTP SMS delivery failed', ['phone' => $phone, 'error' => $exception->getMessage()]);
            return response()->json(['message' => 'ارسال پیامک انجام نشد؛ لطفاً دوباره تلاش کنید.'], 503);
        }
    }

    private function normalizeDigits(?string $value): string
    {
        return str_replace(
            ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],
            ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'],
            trim((string) $value)
        );
    }
}
