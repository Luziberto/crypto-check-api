<?php

namespace App\Services\CoinGecko;

use App\Constants\AssetConstants;
use App\Constants\CoinGeckoErrorConstants;
use App\Constants\CoinGeckoOriginConstants;
use App\Constants\CurrencyConstants;
use App\Exceptions\CoinGeckoHttpException;
use App\Http\Libraries\CoinGecko\Asset\GetAssetSimplePriceRequest;
use App\Http\Libraries\CoinGecko\Asset\GetAssetsListRequest;
use App\Http\Libraries\CoinGecko\Asset\GetSpecificAssetsRequest;
use App\Models\Asset;
use App\Repositories\Asset\AssetRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinServiceInterface
{
    private $assetRepository;

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

        $response = GetAssetSimplePriceRequest::get($params);

        if($response->isFailure()) {
            $this->handleError($response, CoinGeckoOriginConstants::COIN_GECKO_SERVICE_GET_ENDPOINT_TO_GET_SIMPLE_PRICE);
        }

        $data = [];

        foreach ($response->data as $id => $value) {
            $data[] = ['external_id' => $id, 'price' => $value];
        }
        
        $assets = $this->assetRepository->syncAssetsByExternalIds($data);

        return $assets;
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

    private function handleError($response, $coinGeckoErrorOrigin)
    {
        $errorCode = $response->data['message']['codeAsString'] ?? null;
        $errorMessage = CoinGeckoErrorConstants::getErrorMessage($errorCode);

        Log::error("[$coinGeckoErrorOrigin] - " . json_encode($errorMessage));
        throw new CoinGeckoHttpException($errorMessage);
    }
}
