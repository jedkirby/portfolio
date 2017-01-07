<?php

namespace App\Console;

use App;
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
        \App\Services\Twitter\Commands\LatestTweet::class,
        \App\Console\Commands\Instagram::class,
        \App\Console\Commands\Errors::class,
        \App\Console\Commands\Meetup::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('app:meetup')->hourly();
        $schedule->command('app:instagram')->twiceDaily();
        $schedule->command('app:latest-tweet')->everyFiveMinutes();

        if (App::environment('production')) {
            $schedule->command('app:errors')->daily(); // Once every day just gone midnight
        }

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

}