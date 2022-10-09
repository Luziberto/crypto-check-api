<?php

namespace App\Console\Commands;

use App\Constants\CoinBaseConstants;
use App\Models\Asset;
use App\Services\CoinGecko\CoinServiceInterface;
use Illuminate\Console\Command;

class SyncAssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:assets';

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
        $assets = $assetService->getList();
        
        foreach ($assets as $asset) {
            Asset::updateOrCreate([
                'symbol' => strtolower($asset['symbol']),
                'external_id' => $asset['id']
            ], [
                'name' => $asset['name'],
                'slug' => strtolower($asset['name']),
                'coin_base' => CoinBaseConstants::COIN_GECKO,
                'image_path' => config('app.url').'/storage/icons/'.strtolower(str_replace(' ', '-', $asset['id'])).'.png',
            ]);
        }

        $this->info('All assets synced!');
    }
}
