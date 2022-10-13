<?php

namespace App\Services\Asset;

interface AssetServiceInterface
{
    public function getAssetsBySlugs(array $slugs);

    public function syncAssetsPrice(array $assets);

    public function getAssetHistory(string $uuid, string $date);
}