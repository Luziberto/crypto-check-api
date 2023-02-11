<?php

namespace App\Services\Asset;

use App\Constants\CurrencyConstants;

interface AssetServiceInterface
{
    public function getAssetHistory(string $uuid, string $date);

    public function syncPrice(array $assets);

    public function search(string $search, int $perPage, string $orderBy, string $direction);

    public function syncMarketChartByExtId(string $externalId, string $market, ?string $currency = CurrencyConstants::BRL);
}