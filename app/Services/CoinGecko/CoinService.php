<?php

namespace App\Services\CoinGecko;

use App\Constants\CoinBaseConstants;
use App\Constants\CoingeckoConstants;
use App\Constants\CurrencyConstants;
use App\Http\Libraries\CoinGecko\Asset\GetAssetMarketChartRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetSimplePriceRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetsMarketRequest;
use App\Repositories\Asset\AssetRepositoryInterface;
use Illuminate\Http\Client\RequestException;

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

        try {
            $response = GetAssetSimplePriceRequest::get($params)->json();
            
            $data = [];
            foreach ($response as $id => $value) {
                $data[] = [
                    'external_id' => $id,
                    'price_usd'                   => $value[CurrencyConstants::USD],
                    'price_brl'                   => $value[CurrencyConstants::BRL],
                    'coin_base'                   => CoinBaseConstants::COIN_GECKO,
                    'price_change_percentage_24h' => $value['brl_24h_change']
                ];
            }

            return $data;
        } catch(RequestException $e) {
            throw $e;
        }
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

        $response = GetAssetsMarketRequest::get($body)->json();
        
        return $response;
    }

    public function getAssetMarketChart(string $externalId, ?int $days = 90, ?string $currency = CurrencyConstants::BRL)
    {
        $body = [
            'vs_currency' => $currency,
            'days' => $days,
            'interval' => 'daily'
        ];

        $response = GetAssetMarketChartRequest::get($externalId, $body)->json();
        
        return $response;
    }
}
