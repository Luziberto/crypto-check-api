<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use App\Util\ClientResponseUtil;

class GetAssetSimplePriceRequest
{
    public static function get(array $params = []): ClientResponseUtil
    {
        $endpoint = '/simple/price';
        $params['cache'] = microtime();
        logger($params['cache']);
        
        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
