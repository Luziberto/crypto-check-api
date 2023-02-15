<?php

namespace App\Repositories\Asset;

use Illuminate\Pagination\LengthAwarePaginator;
interface AssetRepositoryInterface
{
    public function getBySlugs(array $slugs);
    
    public function getByExternalId(array $externalIds);

    public function syncByExternalIds(array $externalIds);

    public function getAllExternalId();

    public function updateMarketChart(string $externalId, array $market, string $currency);

    public function getByUuid(string $uuid);

    public function search(string $search, int $perPage, string $orderBy, string $direction): LengthAwarePaginator;
}
