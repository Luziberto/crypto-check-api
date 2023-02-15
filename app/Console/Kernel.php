<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
    }

    protected function shortSchedule(\Spatie\ShortSchedule\shortSchedule $shortSchedule)
    {
        $shortSchedule->command('sync:assets-cache')->everySecond(86400);

        $shortSchedule->command('sync:coin-gecko-market-chart')->everySecond(60);
        
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
