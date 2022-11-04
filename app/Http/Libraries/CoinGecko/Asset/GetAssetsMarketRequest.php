<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use App\Util\ClientResponseUtil;

class GetAssetsMarketRequest
{
    public static function get(array $params = []): ClientResponseUtil
    {
        $endpoint = "/coins/markets";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
