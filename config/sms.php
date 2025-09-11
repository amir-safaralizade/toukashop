<?php

use App\Services\Sms\Providers\SmsIrProvider;
use App\Services\Sms\Providers\KavenegarProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Provider
    |--------------------------------------------------------------------------
    |
    | The default SMS provider that will be used if no fallback is triggered.
    |
    */
    'default' => SmsIrProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Fallback Providers
    |--------------------------------------------------------------------------
    |
    | List of providers to attempt if the default one fails.
    |
    */
    'fallback' => [
        SmsIrProvider::class,
        KavenegarProvider::class,
        // اضافه کردن providerهای بیشتر...
    ],

    /*
    |--------------------------------------------------------------------------
    | Provider-specific Settings
    |--------------------------------------------------------------------------
    |
    | You may add specific config for each provider here if needed.
    |
    */
    'providers' => [
        SmsIrProvider::class => [
            // تنظیمات خاص SMS.ir
        ],
        KavenegarProvider::class => [
            'sender' => env('KAVENEGAR_SENDER', '10004346'),
        ],
    ],
];
