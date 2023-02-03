<?php

namespace App\Repositories\Asset;

use Illuminate\Database\Eloquent\Collection;

interface AssetRepositoryInterface
{
    public function getAssetsBySlugs(array $slugs);
    
    public function getAssetsByExternalId(array $externalIds);

    public function syncAssetsByExternalIds(array $externalIds);

    public function getAllExternalId();

    public function getAssetsByUuid(string $uuid);

    public function searchAssets(string $search);
}
