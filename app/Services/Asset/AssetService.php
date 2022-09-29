<?php

namespace App\Services\Asset;

use App\Models\Asset;
use App\Repositories\Asset\AssetRepositoryInterface;

class AssetService implements AssetServiceInterface
{
    private $assetRepository;

    public function __construct(AssetRepositoryInterface $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    public function getAssetsBySlugs(array $slugs)
    {
        $assets = $this->assetRepository->getAssetsBySlugs($slugs);

        return $assets;
    }
}
