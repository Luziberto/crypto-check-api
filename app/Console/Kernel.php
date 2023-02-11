<?php

namespace App\Console;

use App\Jobs\UpdateAssetMarketJob;
use App\Models\Asset;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->call(function () {
          Cache::forever('check_market_asset_list', Asset::all()->pluck('external_id')->toArray());
        })->daily();

       $schedule->job(new UpdateAssetMarketJob)->everyMinute();
    }

    protected function shortSchedule(\Spatie\ShortSchedule\shortSchedule $shortSchedule)
    {
        // this artisan command will run every second
        $shortSchedule->command('sync:assets-price')->everySecond(config('coingecko.sync_time'));
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
