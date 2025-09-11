<?php

namespace App\Services\Payment\Providers;

use App\Models\Order;
use App\Models\Transaction;
use App\Services\Payment\DTOs\PaymentRequestDTO;
use App\Services\Payment\DTOs\PaymentVerifyDTO;
use App\Services\Payment\PaymentGatewayInterface;

class CardToCardGateway implements PaymentGatewayInterface
{
    public function request(PaymentRequestDTO $dto): string
    {
        $order = Order::findOrFail($dto->orderId);

        $transaction = $order->transactions()->create([
            'gateway' => 'manual',
            'amount' => $dto->amount,
            'status' => 'pending',
            'description' => $dto->description,
            'our_token' => $dto->our_token,
            'request_ip' => get_client_ip(),
        ]);

        return route('cart.factor-status', encrypt($transaction->id));
    }

    public function verify(PaymentVerifyDTO $dto): bool
    {
        if ($dto->transaction->status === 'success') {
            return true;
        }

        return false;
    }
}
