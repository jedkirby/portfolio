<?php

namespace App\Console\Commands;

use Log;
use Mail;
use Config;
use Exception;
use Illuminate\Console\Command;
use App\Services\Twitter\Tweet;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;
use App\Services\Twitter\Exceptions\UnableToGetLatestTweetException;

class LatestTweet extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:latest-tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch or update the latest relevant tweet.';

    /**
     * @var TwitterService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TwitterService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @param array $timeline
     *
     * @throws UnableToGetLatestTweetException
     * @return Tweet
     */
    public function getLatestTweet(array $timeline = [])
    {

        $allowedHashtags = TweetManager::getAllowedHashtags();

        foreach ($timeline as $tweet) {
            foreach ($tweet->getHashtags() as $hashtag) {
                if (in_array(strtolower(array_get($hashtag, 'text')), $allowedHashtags)) {
                    return $tweet;
                }
            }
        }

        throw new UnableToGetLatestTweetException('No relevant tweet found.');

    }

    /**
     * @param Tweet $tweet
     *
     * @return boolean
     */
    public function hasTweetChanged(Tweet $tweet)
    {
        if ($storedTweet = TweetManager::getTweet()) {
            return ($storedTweet->getId() !== $tweet->getId());
        }
        return true;
    }

    /**
     * Send an email saying the tweet has changed.
     *
     * @param Tweet $tweet
     *
     * @return void
     */
    public function sendChangedEmail(Tweet $tweet)
    {
        Mail::send(
            'emails.tweet',
            compact('tweet'),
            function($message) {
                $message
                    ->from(
                        Config::get('site.meta.email.from'),
                        'Portfolio'
                    )
                    ->to(
                        Config::get('site.meta.email.to'),
                        Config::get('site.meta.title')
                    )
                    ->subject(
                        'Tweet Update'
                    );
            }
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {

            $timeline = $this->service->getConnection()->getTimeline();

            if ($tweet = $this->getLatestTweet($timeline)) {

                if ($this->hasTweetChanged($tweet)) {
                    $this->sendChangedEmail($tweet);
                }

                TweetManager::setTweet($tweet);

                $this->info(
                    sprintf(
                        'Tweet has been updated/set to: %s',
                        $tweet->getTextRaw()
                    )
                );

            }

        } catch (Exception $e) {
            Log::error($e);
        }

    }

}
