<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'kavenegar' => [
        'key' => env('KAVENEGAR_APIKEY'),
        'sender' => env('KAVENEGAR_SENDER'),
    ],

    'smsir' => [
        'api_key' => env('SMSIR_API_KEY'),
        'secret_key' => env('SMSIR_SECRET_KEY'),
        'line_number' => env('SMSIR_LINE_NUMBER'),
    ],
    'zarinpal' => [
      'merchant_id' => '6a875955-cd80-4f51-9494-f7508d7d33b6'
    ],
    'manage_panel' => 'https://mg.vanell.ir'
];
