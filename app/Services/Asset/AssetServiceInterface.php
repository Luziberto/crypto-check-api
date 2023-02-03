<?php

namespace App\Services\Asset;

interface AssetServiceInterface
{
    public function getAssetHistory(string $uuid, string $date);

    public function syncAssetsPrice(array $assets);
}