<?php

return [

    'zibal' => [
        'merchantId' => '689b172ca45c72001ab59ea3'
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
    'active_provider' => 'AqayePardakht',

];
