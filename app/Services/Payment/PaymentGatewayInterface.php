<?php

namespace App\Services\Payment;

use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;

interface PaymentGatewayInterface
{
    public function request(PaymentRequestDTO $dto): string;

    public function verify(PaymentVerifyDTO $dto): bool;
}
