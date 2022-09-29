<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;
use App\Util\ClientResponseUtil;

class GetSpecificAssetsRequest
{
    public static function get($assetId, array $params = []): ClientResponseUtil
    {
        $endpoint = "/coins/$assetId";

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}
