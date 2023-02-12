<?php

namespace App\Services\Asset;

use App\Constants\CurrencyConstants;
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

    public function syncPrice(array $assets)
    {
        $this->assetRepository->syncByExternalIds($assets);
    }

    public function syncMarketChartByExtId(string $externalId, string $market, ?string $currency = CurrencyConstants::BRL)
    {
        $this->assetRepository->updateMarketChart($externalId, $market, $currency);
    }
}
