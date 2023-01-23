<?php

namespace App\Services\Asset;

use App\Constants\CoingeckoConstants;
use App\Repositories\Asset\AssetRepositoryInterface;
use App\Services\CoinGecko\CoinServiceInterface;
use Carbon\Carbon;

class AssetService implements AssetServiceInterface
{
    private $assetRepository;
    private $coinService;

    public function __construct(AssetRepositoryInterface $assetRepository, CoinServiceInterface $coinService)
    {
        $this->assetRepository = $assetRepository;
        $this->coinService = $coinService;
    }

    public function getAssetsBySlugs(array $slugs)
    {
        $assets = $this->assetRepository->getAssetsBySlugs($slugs);

        return $assets;
    }

    public function syncAssetsPrice(array $assets)
    {
        $this->assetRepository->syncAssetsByExternalIds($assets);
    }

    public function getAssetHistory(string $uuid, string $date)
    {
        $date = $date ? new Carbon($date) : Carbon::now();

        $asset = $this->assetRepository->getAssetsByUuid($uuid);

        $data = $this->coinService->getAssetHistory($asset->external_id, $date->format('d-m-Y'));
        
        return $data;
    }

    public function getAssets(string $search)
    {
        $assets = $this->assetRepository->searchAssets($search);
        
        return $assets;
    }

    public function getAssetsMarketList(array $externalIds)
    {
        $max = count($externalIds) / CoingeckoConstants::MARKET_LIST_PER_PAGE;
        $slot = [];
        for ($index=0; $index <= $max; $index++) { 
            $slot = array_slice($externalIds, ($index * CoingeckoConstants::MARKET_LIST_PER_PAGE), ($index + 1) * CoingeckoConstants::MARKET_LIST_PER_PAGE);
        }

        $assets = $this->coinService->getAssetsMarketList($slot);
        
        return $assets;
    }
}
