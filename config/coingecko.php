<?php

use Illuminate\Support\Facades\Facade;

return [
    'url' => env('COIN_GECKO_BASE_URL', 'https://api.coingecko.com/api/v3'),
    'sync_time' => env('COIN_SYNC_TIME', 10)
];
