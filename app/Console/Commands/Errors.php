<?php

namespace App\Console\Commands;

use App;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Dubture\Monolog\Reader\LogReader;

class Errors extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:errors';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Detect application errors and notify administrators.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		// Log file date we should check
		$date = Carbon::yesterday();

		// Build the name of the log to read
		$path = sprintf(
			'%s/logs/laravel-%s.log',
			App::storagePath(),
			$date->format('Y-m-d')
		);

		// Ensure there is a log file
		if( file_exists($path) ){

			// Storage for each error
			$errors = [];

			// Cycle through all the log items
			$reader = new LogReader($path);			
			foreach($reader as $log){

				// Store only errors
				if(array_get($log, 'level') === 'ERROR'){
					$errors[] = [
						'date'    => array_get($log, 'date'),
						'message' => array_get($log, 'message')
					];
				}

			}

			// Ensure we have at least one error, if so send it!
			if( $errors ){

				$errorCount = count($errors);

				try {

					\Mail::send(
						'emails.errors',
						compact('date', 'errors'),
						function($message) use ($date, $errorCount) {
							$message->from(\Config::get('site.meta.email.from'), 'Portfolio');
							$message->to(\Config::get('site.meta.email.to'), \Config::get('site.meta.title'));
							$message->subject($errorCount.' site errors for '.$date->format('F j'));
						}
					);

				} catch( \Exception $e ) {
					\Log::error($e);
				}

			}

		}

	}

}
