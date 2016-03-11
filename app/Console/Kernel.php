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
		'App\Console\Commands\Tweets',
		'App\Console\Commands\Instagram',
		'App\Console\Commands\Errors',
		'App\Console\Commands\Meetup',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('app:tweets')->everyFiveMinutes();
		$schedule->command('app:instagram')->twiceDaily();
		$schedule->command('app:errors')->daily(); // Once every day just gone midnight
		$schedule->command('app:meetup')->hourly();
	}

}
