<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use Illuminate\Http\Client\Response;

class GetAssetSimplePriceRequest
{
    public static function get(array $params = []): Response
    {
        $endpoint = '/simple/price';
        $params['cache'] = microtime();
        
        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
