<?php

namespace App\Console\Commands;

use App\Jobs\UpdateAssetPriceJob;
use Illuminate\Console\Command;

class UpdateAssetsPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:assets-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update assets price';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UpdateAssetPriceJob::dispatch();
    }
}
