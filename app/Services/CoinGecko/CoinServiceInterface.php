<?php

namespace App\Services\CoinGecko;

interface CoinServiceInterface
{
    public function getList();
    
    public function getAssets(string $id);

    public function getSimplePrice(array $externalIds);

    public function getAssetHistory($id, $params);
}