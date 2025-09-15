<?php

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Services\SettingService;
use App\Services\Sms\SmsService;
use App\Services\Payment\PaymentService;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\Providers\ZarinpalGateway;
use Jenssegers\Agent\Agent;
use Modules\Visit\Services\VisitService;


function slug_generator($text)
{
    $text = preg_replace('/[^ء-یa-zA-Z0-9۰-۹\s-]+/u', '', $text);
    $text = preg_replace('/[\s‌]+/u', '-', $text); // فاصله معمولی و فاصله مجازی
    return trim($text, '-');
}


function get_client_ip()
{
    return request()->header('CF-Connecting-IP')
        ?? request()->header('X-Forwarded-For')
        ?? (request()->isMethod('cli') ? null : request()->ip());
}

function get_user_agent()
{
    $agent = new Agent();
    return $agent->platform() . ' - ' . $agent->browser() . ' - ' . $agent->device() . '-' . $agent->deviceType();
}

function sms(): SmsService
{
    return app(SmsService::class);
}


function gen_transaction_id()
{
    do {
        $code = now()->format('y') . str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);
    } while (Transaction::where('our_token', $code)->exists());

    return $code;
}

function get_logo($type = 'light')
{
    return asset("images/default_logo.png");
}

function super_admins()
{
    return config('property.super_admins');
}

function get_domain()
{
    $url = URL::to('/');
    $parsedUrl = parse_url($url);
    return $domain = $parsedUrl['host'] . $parsedUrl['port'];
}

function is_dark_mode()
{
    if (Auth::check('user')) {
        $has = Cache::get('dark_mode_' . auth()->id());
        if ($has == 'true') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function gen_file_name($file, $prefix = null)
{
    if ($prefix == null) {
        $prefix = 'img';
    }
    return $prefix . '_' . uniqid() . '_' . mt_rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
}

function check_super_admin()
{
    if (!Auth::check() || !in_array(Auth::user()->phone, super_admins())) {
        abort(403);
    }

    return true;
}


function setting(string $key, $default = null)
{
    return app(SettingService::class)->get($key, $default);
}

function get_product_image(Product $product)
{
    return $product->firstMedia('main_image') ? asset($product->firstMedia('main_image')->path) : asset('placeholder.png');
}

function recordVisit($model)
{
    $visitService = new VisitService();
    $visitService->record($model);
}

function persian_slug($string, $separator = '-')
{
    // Replace spaces and underscores with separator
    $slug = preg_replace('/[\s_]+/u', $separator, trim($string));

    // Remove all characters except Persian/English letters, numbers and separator
    $slug = preg_replace('/[^آ-یa-zA-Z0-9\-]+/u', '', $slug);

    // Remove multiple separators
    $slug = preg_replace('/-+/', '-', $slug);

    return trim($slug, $separator);
}


