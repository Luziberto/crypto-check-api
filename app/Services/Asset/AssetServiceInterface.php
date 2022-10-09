<?php

namespace App\Services\Asset;

interface AssetServiceInterface
{
    public function getAssetsBySlugs(array $slugs);

    public function syncAssetsPrice(array $assets);
}