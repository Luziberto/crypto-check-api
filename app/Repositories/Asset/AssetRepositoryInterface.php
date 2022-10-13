<?php

namespace App\Repositories\Asset;

interface AssetRepositoryInterface
{
    public function getAssetsBySlugs(array $slugs);
    
    public function getAssetsByExternalIds(array $externalIds);

    public function syncAssetsByExternalIds(array $externalIds);

    public function getAssetsByUuid(string $uuid);
}
