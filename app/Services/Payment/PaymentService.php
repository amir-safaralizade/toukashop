<?php

namespace App\Services\Payment;

use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;
use App\Services\Payment\PaymentGatewayInterface;

class PaymentService
{
    public function __construct(
        protected PaymentGatewayResolver $resolver
    ) {}

    /**
     * شروع فرآیند پرداخت
     */
    public function pay(PaymentRequestDTO $dto): string
    {
        logger('provider selected: ' . $dto->provider);
        $gateway = $this->resolver->resolve($dto->provider);
        return $gateway->request($dto);
    }

    /**
     * تأیید تراکنش پرداخت
     */
    public function verify(PaymentVerifyDTO $dto): bool
    {
        $gateway = $this->resolver->resolve($dto->transaction->gateway);
        return $gateway->verify($dto);
    }
}
