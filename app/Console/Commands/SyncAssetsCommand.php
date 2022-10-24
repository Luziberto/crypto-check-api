<?php

namespace App\Console\Commands;

use App\Constants\CoinBaseConstants;
use App\Models\Asset;
use App\Services\CoinGecko\CoinServiceInterface;
use App\Services\GoogleDrive\FileServiceInterface;
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
    public function handle(CoinServiceInterface $assetService, FileServiceInterface $fileService)
    {
        $assets = $assetService->getList();
        
        $files = $fileService->list();
        
        foreach ($assets as $asset) {
            $name = strtolower(str_replace(' ', '-', $asset['id']));
            $filePath = isset($files[$name]) ? $files[$name] : null;

            Asset::updateOrCreate([
                'symbol' => strtolower($asset['symbol']),
                'external_id' => $asset['id']
            ], [
                'name' => $asset['name'],
                'slug' => strtolower($asset['name']),
                'coin_base' => CoinBaseConstants::COIN_GECKO,
                'image_path' => $filePath,
            ]);
        }

        $this->info('All assets synced!');
    }
}
