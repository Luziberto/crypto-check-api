<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use Illuminate\Http\Client\Response;

class GetSpecificAssetsRequest
{
    public static function get($assetId, array $params = []): Response
    {
        $endpoint = "/coins/$assetId";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
