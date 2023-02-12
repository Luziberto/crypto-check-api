<?php

namespace App\Constants;

class CoingeckoConstants
{
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS = 'CoinGeckoService#getEndpointToGetAssets';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_LIST_ASSETS = 'CoinGeckoService#getEndpointToListAssets';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_SIMPLE_PRICE = 'CoinGeckoService#getEndpointToGetSimplePrice';
    const COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS_MARKET = 'CoinGeckoService#getEndpointToGetAssetsMarket';

    const DEFAULT_ERROR_MESSAGE = 'Something unexpected happened. If the problem persists, contact support.';

    const MARKET_LIST_PER_PAGE = 200;
    const MARKET_LIST_TOTAL_PAGES = 5;
    const SIMPLE_PRICE_PER_PAGE = 500;
    
    static function getErrorMessage($errorCode)
    {
        return self::DEFAULT_ERROR_MESSAGE;
    }
}
