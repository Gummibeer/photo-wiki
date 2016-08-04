<?php

namespace App\Console;

use App\Console\Commands\CompileViews;
use App\Console\Commands\CreateUser;
use App\Console\Commands\ImportCalendar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CompileViews::class,
        CreateUser::class,
        ImportCalendar::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('auth:clear-resets')->hourly();
        $schedule->command('bouncer:seed')->hourly();
        $schedule->command('calendar:import')->hourly();
    }
}
