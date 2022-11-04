<?php

namespace App\Console\Commands;

use App\Constants\CoingeckoConstants;
use App\Constants\CoinBaseConstants;
use App\Models\Asset;
use App\Services\CoinGecko\CoinServiceInterface;
use Illuminate\Console\Command;

class SyncCoingeckoAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:coin-gecko-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Assets List';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CoinServiceInterface $assetService)
    {
        $assets = $assetService->getAssetsMarketList(CoingeckoConstants::ASSETS_COIN_GECKO_ID);
        
        foreach ($assets as $asset) {
            Asset::updateOrCreate([
                'symbol' => strtolower($asset['symbol']),
                'external_id' => $asset['id']
            ], [
                'name' => $asset['name'],
                'slug' => strtolower($asset['name']),
                'coin_base' => CoinBaseConstants::COIN_GECKO,
                'image_path' => $asset['image'],
                'price_change_percentage_24h' => $asset['price_change_percentage_24h'],
            ]);
        }

        $this->info('All assets synced!');
    }
}
