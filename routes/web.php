<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\IdentifyAnonymousClient;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\api\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OTPController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SiteMapCpntroller;

Route::middleware(IdentifyAnonymousClient::class)->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('login', 'loginView')->name('login-view');
        Route::Post('login', 'login')->name('login');
        Route::get('register', 'registerView')->name('register-view');
        Route::post('register', 'register')->name('register');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::get('/', [HomeController::class, 'home'])->name('page.home');
    Route::get('privacy', [HomeController::class, 'privacy'])->name('page.privacy');
    Route::get('order-tracking', [HomeController::class, 'orderTracking'])->name('page.orderTracking');

    Route::prefix('products')->controller(ProductController::class)->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{slug}', 'product')->name('show');
        Route::get('/category/{slug}', 'category')->name('categories');
        Route::get('/testtt', 'tests');
    });

    Route::prefix('cart')->controller(CartController::class)->name('cart.')->group(function () {
        Route::get('mycart', 'mycart')->name('mycart');
        Route::get('add-to-cart/{product}', 'addToCart')->name('addToCart');
        Route::delete('/item/{item}/delete', 'deleteFromCart')->name('deleteFromCart');
        Route::post('/clear', 'clear')->name('cart.clear');
        Route::post('finalize', 'finalize')->name('finalize');
        Route::get('clear', 'clear')->name('clear');
        Route::get('coupon/apply', 'couponApply')->name('coupon.apply');
        Route::post('/update-quantity/{item}', 'updateQuantity')->name('updateQuantity');
        Route::post('/api/add', 'addToCartAjax')->name('addToCartAjax');
        Route::get('/item-count', 'getItemCount')->name('itemCount');
        Route::get('/factor-status/{transaction}', 'FactorStatus')->name('factor-status');
    });

    Route::prefix('posts')->controller(PostController::class)->name('posts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{post}', 'show')->name('show');
    });

    Route::controller(CheckoutController::class)->prefix('checkout')->group(function () {
        Route::get('/pay/{order_id}/{provider}', 'redirectToGateway')->name('payment.redirect');
        Route::any('/payment/callback/{our_token}', 'paymentCallback')->name('payment.callback')->withoutMiddleware([VerifyCsrfToken::class]);
    });
});

Route::prefix('api')->group(function () {
    Route::get('cities', [PublicController::class, 'getCities']);
    Route::post('/send-otp', [OTPController::class, 'send'])->name('otp.send');
});

Route::get('sitemap/generation', [SiteMapCpntroller::class, 'generate'])->name('sitemap.generation');
