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
        \App\Services\Instagram\Commands\LatestPosts::class,
        \App\Console\Commands\Errors::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('instagram:latest-posts')->twiceDaily();
        $schedule->command('twitter:latest-tweet')->everyFiveMinutes();

        if (App::environment('production')) {
            $schedule->command('app:errors')->daily(); // Once every day just gone midnight
        }
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
