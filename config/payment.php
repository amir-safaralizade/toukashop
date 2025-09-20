<?php

return [

    'zibal' => [
        'merchantId' => '68ce466fa45c72000ed7bc10'
    ],

    'AqayePardakht' => [
        'pin' => '3A658C96142824DFAB92'
    ],

    'gateways' => [
        'AqayePardakht' => \App\Services\Payment\Providers\AqayePardakhtGateway::class,
        'zibal' => \App\Services\Payment\Providers\ZibalGateway::class,
        'card_to_card' => \App\Services\Payment\Providers\CardToCardGateway::class,
    ],


    'default' => 'zibal',
    'active_provider' => 'zibal',

];
