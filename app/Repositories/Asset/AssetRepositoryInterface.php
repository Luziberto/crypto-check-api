<?php

namespace App\Repositories\Asset;

interface AssetRepositoryInterface
{
    public function getAssetsBySlugs(array $slugs);
    
    public function getAssetsByExternalId(array $externalIds);

    public function syncAssetsByExternalIds(array $externalIds);

    public function getAssetsByUuid(string $uuid);

    public function searchAssets(string $search);
}
