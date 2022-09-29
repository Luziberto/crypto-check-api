<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use App\Util\ClientResponseUtil;

class GetAssetsListRequest
{
    public static function get(array $params = []): ClientResponseUtil
    {
        $endpoint = "/coins/list";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
