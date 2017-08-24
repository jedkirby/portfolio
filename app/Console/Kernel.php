<?php

namespace App\Console;

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
        \App\Domain\Service\Twitter\Console\Command\LatestTweet::class,
        \App\Domain\Service\Instagram\Console\Command\LatestPosts::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('twitter:latest-tweet')->everyFiveMinutes();
        $schedule->command('instagram:latest-posts')->twiceDaily();
    }
}
