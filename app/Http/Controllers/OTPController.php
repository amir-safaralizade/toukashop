<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VerificationCode;
class OTPController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09\d{9}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'شماره وارد شده معتبر نیست',
                'errors' => $validator->errors(),
            ], 422);
        }

        $phone = $request->phone;

        // حذف کدهای قبلی تأیید نشده
        VerificationCode::where('phone', $phone)
            ->where('verified', false)
            ->delete();

        // ساخت و ذخیره کد
        $otp = VerificationCode::generate($phone);

        // ارسال با سرویس پیامک
        try {
            // اینجا سرویس SMS خودتو صدا بزن، مثلاً:
            // SmsService::send($phone, "کد تایید شما: {$otp->code}");

            return response()->json([
                'success' => true,
                'message' => 'کد با موفقیت ارسال شد',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'ارسال پیامک با خطا مواجه شد',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
