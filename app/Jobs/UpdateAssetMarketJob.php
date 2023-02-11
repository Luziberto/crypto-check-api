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
        logger('UpdateAssetMarketJob');
        $externalIds = Cache::get('check_market_asset_list', []);
        $assets = 5;
        if (count($externalIds)) {
            for ($i=1; $i <= $assets; $i++) {
                $externalId = array_shift($externalIds);
                logger('UpdateAssetMarketJob: '. $externalId);
                
                $market = $coinService->getAssetMarketChart(externalId: $externalId, currency: CurrencyConstants::BRL);
                $assetService->syncMarketChartByExtId($externalId, $market, CurrencyConstants::BRL);
                
                $market = $coinService->getAssetMarketChart(externalId: $externalId, currency: CurrencyConstants::USD);
                $assetService->syncMarketChartByExtId($externalId, $market, CurrencyConstants::USD);
                sleep(3);
            }
            Cache::forever('check_market_asset_list', $externalIds);
        }
    }
}
