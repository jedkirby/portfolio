<?php

namespace App\Console\Commands;

use App;
use Log;
use Mail;
use Config;
use Exception;
use Illuminate\Console\Command;
use App\Integrations\Twitter\Tweet;
use App\Integrations\Twitter as TwitterIntegration;
use Pixelate\Shared\Social\Stream\Twitter as TwitterStream;

class Tweets extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:tweets';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch the latest tweet from a spcific account which matches specific hashtags';

	/**
	 * Hashtag to find the latest tweet with. Make sure this is lowercase.
	 *
	 * @var string
	 */
	protected $hashtags = ['work', 'php', 'php7', 'javascript', 'confrence', 'phpwarks', 'ssl'];

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$twitter = new TwitterStream;
		$twitter->setConsumerKey(Config::get('site.social.streams.twitter.api.consumer_key'));
		$twitter->setConsumerSecret(Config::get('site.social.streams.twitter.api.consumer_secret'));
		$twitter->setToken(Config::get('site.social.streams.twitter.api.token'));
		$twitter->setTokenSecret(Config::get('site.social.streams.twitter.api.token_secret'));
		$twitter->setUserScreenName(Config::get('site.social.streams.twitter.name'));

		// Attempt to get the twitter feed
		if (($tweets = $twitter->getFeed())) {

			// Find the latest hashtagged tweet
			if (($tweet = $this->pluckReleventTweet($tweets))) {

				// Generate a useable Tweet object from the tweet
				$tweet = TwitterIntegration::createTweetFromArray($tweet);

				// If the tweet has changed, email to notify
				if ($this->hasTweetChanged($tweet) && App::environment('production')) {
					$this->emailTweetChange($tweet);
				}

				// Store the relevant
				TwitterIntegration::storeTweet($tweet);

				// Give some output
				$this->info('Latest Tweets fetched!');

			} else {

				// Give some output
				$this->info('Unable to pluck a latest Tweet.');

			}

		} else {

			// We have an issue
			$this->info('Failed to fetch latest Tweets.');

		}

	}

	/**
	 * Search through tweets to find the relevent hashtag.
	 *
	 * @param  array $tweets
	 * @return mixed
	 */
	private function pluckReleventTweet($tweets)
	{
		foreach ($tweets as $t) {
			foreach (array_get($t, 'entities.hashtags', []) as $h) {
				if (in_array(strtolower(array_get($h, 'text')), array_map('strtolower', $this->hashtags))) {
					return $t;
				}
			}
		}
		return false;
	}

	/**
	 * Determine if the tweet has changed.
	 *
	 * @param  Tweet $tweet
	 * @return boolean
	 */
	private function hasTweetChanged(Tweet $tweet)
	{
		if (($previousTweet = TwitterIntegration::getLatest())) {
			return ($previousTweet->getId() !== $tweet->getId());
		}
		return true;
	}

	/**
	 * Email the change in tweet for review.
	 *
	 * @param  Tweet $tweet
	 * @return void
	 */
	private function emailTweetChange(Tweet $tweet)
	{
		try {
			Mail::send(
				'emails.tweet',
				compact('tweet'),
				function($message) {
					$message->from(\Config::get('site.meta.email.from'), 'Portfolio');
					$message->to(Config::get('site.meta.email.to'), Config::get('site.meta.title'));
					$message->subject('Tweet Update');
				}
			);
		} catch (Exception $e) {
			Log::error($e);
		}
	}

}
