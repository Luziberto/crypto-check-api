<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use Illuminate\Http\Client\Response;

class GetAssetsMarketRequest
{
    public static function get(array $params = []): Response
    {
        $endpoint = "/coins/markets";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
