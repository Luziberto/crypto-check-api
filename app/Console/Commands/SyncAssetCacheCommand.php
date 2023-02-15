<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SyncAssetCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:assets-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill assets cache according to assets table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Cache::forever('check_market_asset_list', Asset::all()->pluck('external_id')->toArray());
    }
}
