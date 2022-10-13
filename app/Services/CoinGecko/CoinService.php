<?php

namespace App\Services\CoinGecko;

use App\Constants\CoinBaseConstants;
use App\Constants\CoinGeckoErrorConstants;
use App\Constants\CoinGeckoOriginConstants;
use App\Constants\CurrencyConstants;
use App\Exceptions\CoinGeckoHttpException;
use App\Http\Libraries\CoinGecko\Asset\GetAssetHistoryRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetSimplePriceRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetsListRequest;
use App\Http\Libraries\CoinGecko\Asset\GetSpecificAssetsRequest;
use App\Repositories\Asset\AssetRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinServiceInterface
{
    public function __construct(AssetRepositoryInterface $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    public function getSimplePrice(array $externalIds)
    {
        $params = [
            'ids' => implode(',', $externalIds), 
            'vs_currencies' => CurrencyConstants::BRL
        ];

        logger($params);
        $response = GetAssetSimplePriceRequest::get($params);
        logger($response->data);
        if($response->isFailure()) {
            $this->handleError($response, CoinGeckoOriginConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_SIMPLE_PRICE);
        }

        $data = [];
        
        foreach ($response->data as $id => $value) {
            $data[] = ['external_id' => $id, 'price' => $value[CurrencyConstants::BRL], 'coin_base' => CoinBaseConstants::COIN_GECKO];
        }

        return $data;
    }

    public function getList()
    {
        $response = GetAssetsListRequest::get();

        if($response->isFailure()) {
            $this->handleError($response, CoinGeckoOriginConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_LIST_ASSETS);
        }
        
        return $response->data;
    }
    
    public function getAssets($id)
    {
        $response = GetSpecificAssetsRequest::get($id)->data;

        if($response->isFailure()) {
            $this->handleError($response, CoinGeckoOriginConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSETS);
        }
    }

    public function getAssetHistory($id, $date)
    {
        $response = GetAssetHistoryRequest::get($id, ['date' => $date]);
        
        if($response->isFailure()) {
            $this->handleError($response, CoinGeckoOriginConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_ASSET_HISTORY);
        }

        return $response->data;
    }

    private function handleError($response, $coinGeckoErrorOrigin)
    {
        $errorCode = $response->data['message']['codeAsString'] ?? null;
        $errorMessage = CoinGeckoErrorConstants::getErrorMessage($errorCode);

        Log::error("[$coinGeckoErrorOrigin] - " . json_encode($errorMessage));
        throw new CoinGeckoHttpException($errorMessage);
    }
}
