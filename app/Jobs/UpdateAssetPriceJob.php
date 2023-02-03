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
        
        if (count($externalIds)) {
            $pages = ceil(count($externalIds)/CoingeckoConstants::SIMPLE_PRICE_PER_PAGE);
            
            for ($i=1; $i <= $pages; $i++) {
                logger('count =>'.$i);
                $coins = $coinService->getSimplePrice(array_slice($externalIds, ($i - 1) * CoingeckoConstants::SIMPLE_PRICE_PER_PAGE, $i * CoingeckoConstants::SIMPLE_PRICE_PER_PAGE));
                $assetService->syncPrice($coins);
            }
           
        }
    }
}
