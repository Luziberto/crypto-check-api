<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use App\Util\ClientResponseUtil;

class GetAssetMarketChartRequest
{
    public static function get(string $id, array $params): ClientResponseUtil
    {
        $endpoint = "/coins/$id/market_chart";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
