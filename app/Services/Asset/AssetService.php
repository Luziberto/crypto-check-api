<?php

namespace App\Services\Asset;

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
    public function getAssetHistory(string $uuid, string $date)
    {
        $date = $date ? new Carbon($date) : Carbon::now();

        $asset = $this->assetRepository->getAssetsByUuid($uuid);

        $data = $this->coinService->getAssetHistory($asset->external_id, $date->format('d-m-Y'));
        
        return $data;
    }

    public function syncAssetsPrice(array $assets)
    {
        $this->assetRepository->syncAssetsByExternalIds($assets);
    }
}
