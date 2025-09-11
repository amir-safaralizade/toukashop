<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Sms\SmsService;

class Sms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SmsService::class;
    }
}
