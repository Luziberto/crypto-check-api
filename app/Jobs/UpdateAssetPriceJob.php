<?php

namespace App\Jobs;

use App\Constants\CoingeckoConstants;
use App\Repositories\Asset\AssetRepositoryInterface;
use App\Services\Asset\AssetServiceInterface;
use App\Services\CoinGecko\CoinServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAssetPriceJob implements ShouldQueue
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
    public function handle(AssetServiceInterface $assetService, AssetRepositoryInterface $assetRepository, CoinServiceInterface $coinService)
    {
        $externalIds = $assetRepository->getAllExternalId()->pluck('external_id')->toArray();
        logger($externalIds);
        if (count($externalIds)) {
            $coins = $coinService->getSimplePrice($externalIds);
            $assetService->syncAssetsPrice($coins);
        }
    }
}
