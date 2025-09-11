<?php

namespace App\Services\Payment\DTOs;

use App\Models\Transaction;

class PaymentVerifyDTO
{
    public Transaction $transaction;
    public array $requestData;

    public function __construct(Transaction $transaction, array $requestData = [])
    {
        $this->transaction = $transaction;
        $this->requestData = $requestData;
    }
}
