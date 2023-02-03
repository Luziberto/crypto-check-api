<?php

namespace App\Services\Asset;


interface AssetServiceInterface
{
    public function getAssetHistory(string $uuid, string $date);

    public function syncPrice(array $assets);

    public function search(string $search, int $perPage, string $orderBy, string $direction);
}