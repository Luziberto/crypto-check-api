<?php

namespace App\Services\CoinGecko;

use App\Constants\CoinBaseConstants;
use App\Constants\CoingeckoConstants;
use App\Constants\CurrencyConstants;
use App\Exceptions\CoinGeckoHttpException;
use App\Http\Libraries\CoinGecko\Asset\GetAssetHistoryRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetMarketChartRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetSimplePriceRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetsListRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetsMarketRequest;
use App\Http\Libraries\CoinGecko\Asset\GetSpecificAssetsRequest;
use App\Repositories\Asset\AssetRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinServiceInterface
{
    public $assetRepository;
    
    public function __construct(AssetRepositoryInterface $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    public function getSimplePrice(array $externalIds)
    {
        $params = [
            'ids' => implode(',', $externalIds), 
            'vs_currencies' => CurrencyConstants::BRL.','.CurrencyConstants::USD,
            'include_24hr_change' => 'true'
        ];

        $response = GetAssetSimplePriceRequest::get($params);
        
        if($response->isFailure()) {
            $this->handleError($response, CoingeckoConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_SIMPLE_PRICE);
        }

        $data = [];

        foreach ($response->data as $id => $value) {
            $data[] = [
                'external_id' => $id,
                'price_usd'                   => $value[CurrencyConstants::USD],
                'price_brl'                   => $value[CurrencyConstants::BRL],
                'coin_base'                   => CoinBaseConstants::COIN_GECKO,
                'price_change_percentage_24h' => $value['brl_24h_change']
            ];
        }

        return $data;
    }

    public function getAssetsMarketList(?array $externalIds = [], ?int $page = 1, ?string $order = 'market_cap_desc')
    {
        $body = [
            'ids' => implode(',', $externalIds),
            'vs_currency' => CurrencyConstants::BRL,
            'per_page' => CoingeckoConstants::MARKET_LIST_PER_PAGE,
            'page' => $page,
            'order' => $order
        ];

        $response = GetAssetsMarketRequest::get($body);

        if($response->isFailure()) {
            $this->handleError($response, CoingeckoConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS_MARKET);
        }
        
        return $response->data;
    }

    public function getAssetMarketChart(string $externalId, ?int $days = 90, ?string $currency = CurrencyConstants::BRL)
    {
        $body = [
            'vs_currency' => $currency,
            'days' => $days,
            'interval' => 'daily'
        ];

        $response = GetAssetMarketChartRequest::get($externalId, $body);

        if($response->isFailure()) {
            $this->handleError($response, CoingeckoConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS_MARKET);
        }
        
        return $response->data;
    }

    public function getAssetHistory($id, $date)
    {
        $response = GetAssetHistoryRequest::get($id, ['date' => $date]);
        
        if($response->isFailure()) {
            $this->handleError($response, CoingeckoConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSET_HISTORY);
        }

        return $response->data;
    }

    private function handleError($response, $coinGeckoErrorOrigin)
    {
        $errorCode = $response->data['message']['codeAsString'] ?? null;
        $errorMessage = CoingeckoConstants::getErrorMessage($errorCode);

        Log::error("[$coinGeckoErrorOrigin] - " . json_encode($errorMessage));
        throw new CoinGeckoHttpException($errorMessage);
    }
}
