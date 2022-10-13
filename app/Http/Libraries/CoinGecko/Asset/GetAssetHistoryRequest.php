<?php

namespace App\Http\Libraries\CoinGecko\Asset;

use App\Http\Libraries\CoinGecko\CoinGeckoHttpClient;

class GetAssetHistoryRequest
{
    
    public static function get($id, $params)
    {
        $endpoint = "/coins/$id/history";
        $params['localization'] = 'false';

        return CoinGeckoHttpClient::get($endpoint, $params);
    }
}

