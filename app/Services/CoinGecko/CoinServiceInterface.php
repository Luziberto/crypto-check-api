<?php

namespace App\Services\CoinGecko;

interface CoinServiceInterface
{
    public function getAssetHistory($id, $params);

    public function getAssetsMarketList(array $assets);

    public function getSimplePrice(array $externalIds);
}