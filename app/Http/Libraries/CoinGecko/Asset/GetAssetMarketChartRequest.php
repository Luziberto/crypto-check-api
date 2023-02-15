<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use Illuminate\Http\Client\Response;

class GetAssetMarketChartRequest
{
    public static function get(string $id, array $params): Response
    {
        $endpoint = "/coins/$id/market_chart";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
