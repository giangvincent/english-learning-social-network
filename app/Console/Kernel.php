<?php

namespace App\Console;

use App\Repositories\ExportJson;
use App\Repositories\PushNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            ExportJson::SaveNotification();
        })->hourly();

        $schedule->call(function () {
            PushNotification::sendMail();
        })->dailyAt('9:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
