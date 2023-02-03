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

    public function search(?string $search = '', ?int $perPage = 10, ?string $orderBy = 'name', ?string $direction = 'desc')
    {
        return $this->assetRepository->search($search, $perPage, $orderBy, $direction);
    }

    public function getAssetHistory(string $uuid, string $date)
    {
        $date = $date ? new Carbon($date) : Carbon::now();

        $asset = $this->assetRepository->getByUuid($uuid);

        $data = $this->coinService->getAssetHistory($asset->external_id, $date->format('d-m-Y'));
        
        return $data;
    }

    public function syncPrice(array $assets)
    {
        $this->assetRepository->syncByExternalIds($assets);
    }
}
