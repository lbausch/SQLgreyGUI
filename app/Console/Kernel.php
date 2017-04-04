<?php

namespace SQLgreyGUI\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use SQLgreyGUI\Console\Commands\DeleteUndefRecords;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DeleteUndefRecords::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(DeleteUndefRecords::class)
            ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
