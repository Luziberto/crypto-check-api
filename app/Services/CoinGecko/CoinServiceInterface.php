<?php

namespace App\Services\CoinGecko;

use App\Constants\CurrencyConstants;

interface CoinServiceInterface
{
    public function getAssetsMarketList(array $assets);

    public function getSimplePrice(array $externalIds);

    public function getAssetMarketChart(string $externalId, ?int $days = 90, ?string $currency = CurrencyConstants::BRL);
}