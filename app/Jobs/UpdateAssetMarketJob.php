<?php

namespace App\Jobs;

use App\Constants\CurrencyConstants;
use App\Services\Asset\AssetServiceInterface;
use App\Services\CoinGecko\CoinServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateAssetMarketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AssetServiceInterface $assetService, CoinServiceInterface $coinService)
    {
        $externalIds = Cache::get('check_market_asset_list', []);
        $qttAssets = 5;

        if (count($externalIds) < $qttAssets) $qttAssets = count($externalIds);
        if (count($externalIds)) {
            for ($i=1; $i <= $qttAssets; $i++) {
                $externalId = array_shift($externalIds);
                try {
                    $market = $coinService->getAssetMarketChart(externalId: $externalId, currency: CurrencyConstants::BRL);
                    $assetService->syncMarketChartByExtId($externalId, $market, CurrencyConstants::BRL);
                    
                    $market = $coinService->getAssetMarketChart(externalId: $externalId, currency: CurrencyConstants::USD);
                    $assetService->syncMarketChartByExtId($externalId, $market, CurrencyConstants::USD);
                } catch (\Throwable $th) {
                    array_unshift($externalIds, $externalId);
                }
            }
            Cache::forever('check_market_asset_list', $externalIds);
        }
    }
}
