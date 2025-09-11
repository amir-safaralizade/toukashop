<?php

namespace App\Services\Payment\DTOs;

class PaymentRequestDTO
{
    public function __construct(
        public int    $orderId,
        public int    $amount,
        public string $callbackUrl,
        public string $description = '',
        public string $our_token,
        public string $provider
    ) {}
}
