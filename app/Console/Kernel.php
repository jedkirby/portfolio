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
        \App\Domain\Service\Twitter\Command\LatestTweet::class,
        \App\Domain\Service\Instagram\Command\LatestPosts::class,
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
    }
}
