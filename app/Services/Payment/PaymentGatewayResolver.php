<?php

namespace App\Services\Payment;

use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class PaymentGatewayResolver
{
    public function __construct(
        protected Container $app
    ) {}

    /**
     * گرفتن یک درگاه پرداخت به صورت داینامیک
     */
    public function resolve(?string $gateway = null): PaymentGatewayInterface
    {
        $gateway = $gateway ?? config('payment.active_provider');
        $gateways = config('payment.gateways');

        if (!array_key_exists($gateway, $gateways)) {
            abort(404);
        }

        return $this->app->make($gateways[$gateway]);
    }
}
