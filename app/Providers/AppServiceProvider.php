<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use App\Listeners\LogFailedLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Services\Sms\SmsService;
use App\Services\Sms\SmsProviderInterface;
use App\Services\Sms\Providers\FallbackSmsProvider;
use App\Services\Auth\PasswordResetSession;
use App\Services\Payment\PaymentService;
use App\Services\Payment\PaymentGatewayResolver;
use Kavenegar\Laravel\Facade as KavenegarFacade;
use App\Services\OrderService;
use Illuminate\Support\Facades\View;
use Modules\Seo\SeoServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the main SMS service with dynamic fallback from config/sms.php
        $this->app->singleton(SmsService::class, function ($app) {
            $providerClasses = config('sms.fallback', []);
            $providers = array_map(fn($class) => $app->make($class), $providerClasses);

            return new SmsService(new FallbackSmsProvider($providers));
        });

        // Bind SmsProviderInterface for dependency injection
        $this->app->bind(SmsProviderInterface::class, function ($app) {
            $defaultClass = config('sms.default');
            return $app->make($defaultClass);
        });

        // Password reset session service
        $this->app->singleton(PasswordResetSession::class);

        // Payment service
        $this->app->singleton(PaymentService::class, fn($app) => new PaymentService($app->make(PaymentGatewayResolver::class)));


        // Register Alias for Kavenegar
        $this->app->alias(KavenegarFacade::class, 'Kavenegar');

        $this->app->register(SeoServiceProvider::class);

        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, [LogSuccessfulLogin::class, 'handle']);
        Event::listen(Logout::class, [LogSuccessfulLogout::class, 'handle']);
        Event::listen(Failed::class, [LogFailedLogin::class, 'handle']);

        View::composer('*', function ($view) {
            $cartCount = (new OrderService())->getCurrentCart(false, true);
            $view->with('cartItemCount', $cartCount);
        });
    }
}
