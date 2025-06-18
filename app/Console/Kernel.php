<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Sabberworm\CSS\Property\Import;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // Di app/Console/Kernel.php
        // app/Console/Kernel.php
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:pending-payments')->everyFiveMinutes();
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
