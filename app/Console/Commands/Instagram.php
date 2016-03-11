<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class Instagram extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:instagram';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch the latest instagram posts';

	/**
	 * The amount of posts to store.
	 * 
	 * @var integer
	 */
	protected $postLimit = 8;

	/**
	 * An array of image ID's to ignore and not store for use on the website.
	 *
	 * @var array
	 */
	protected $ignoreIds = [];

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$instagram = new \Pixelate\Shared\Social\Stream\Instagram;
		$instagram->setAccessToken(\Config::get('site.social.streams.instagram.api.access_token'));
		$instagram->setUserId(\Config::get('site.social.streams.instagram.id'));

		// Attempt to get the instagram feed
		if( ($feed = $instagram->getFeed()) ){

			// Remove any ignored images
			$allowedFeed = $this->removeIgnoredImages($feed);

			// Store the tweet in the cache
			$this->storeFeedInCache($allowedFeed);

		}
		else {

			// Notify about the failure
			$this->emailFailure();

		}

	}

	/**
	 * Cycle through the feed and ensure only allowed images are returned,
	 * then return the max allowed images.
	 *
	 * @param  array $feed
	 * @return array
	 */
	protected function removeIgnoredImages($feed)
	{
		$allowedFeed = [];
		foreach($feed as $image){
			if(!in_array($image['id'], $this->ignoreIds)){
				$allowedFeed[] = $image;
			}
		}
		return array_slice($allowedFeed, 0, $this->postLimit);
	}

	/**
	 * Store the instagram feed in the cache forever.
	 * 
	 * @param  array $feed
	 * @return void
	 */
	protected function storeFeedInCache($feed = [])
	{
		\Cache::forever('instagram', $feed);
	}

	/**
	 * Email when fetching failed.
	 * 
	 * @return void
	 */
	protected function emailFailure()
	{

		if( !\App::environment('production') ) return;

		try {

			\Mail::send(
				'emails.instagram.failed',
				[],
				function($message) {
					$message->from(\Config::get('site.meta.email.from'), 'Portfolio');
					$message->to(\Config::get('site.meta.email.to'), \Config::get('site.meta.title'));
					$message->subject('Instagram Fetch Failure');
				}
			);

		} catch( \Exception $e ) {
			\Log::error($e);
		}

	}

}
