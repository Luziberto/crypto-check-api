<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAssetMarketJob;
use App\Models\Asset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SyncCoinGeckoMarketChart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:coin-gecko-market-chart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get market cap by crypto coin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Cache::forever('check_market_asset_list', Asset::all()->pluck('external_id')->toArray());
        // UpdateAssetMarketJob::dispatch()->onQueue('market_cap');
    }
}
