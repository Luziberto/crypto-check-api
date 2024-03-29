<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAssetMarketJob;
use Illuminate\Console\Command;

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
        UpdateAssetMarketJob::dispatch();
    }
}
