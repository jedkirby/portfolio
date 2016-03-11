<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerNewRelic();
	}

	/**
	 * Register the New Relic handler.
	 * 
	 * @return void
	 */
	public function registerNewRelic()
	{
		if(extension_loaded('newrelic')){
			if( ($host = env('NR_HOST')) && ($key = env('NR_KEY')) ){
				newrelic_set_appname($host, $key);
			}
		}
	}

}
