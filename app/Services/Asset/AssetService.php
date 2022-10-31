<?php

namespace App\Services\Asset;

use App\Repositories\Asset\AssetRepositoryInterface;
use App\Services\CoinGecko\CoinServiceInterface;
use Carbon\Carbon;

class AssetService implements AssetServiceInterface
{
    private $assetRepository;

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
}
