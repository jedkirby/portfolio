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
     * Send an email saying the tweet has changed.
     *
     * @param Tweet $tweet
     *
     * @return void
     */
    public function sendChangedEmail(Tweet $tweet)
    {

        // Move to Job

        /*
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
        */
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
            $allowedHashtags = TweetManager::getAllowedHashtags();

            if ($tweet = TweetManager::getLatestTweet($timeline, $allowedHashtags)) {

                if (TweetManager::hasTweetChanged($tweet)) {
                    // $this->sendChangedEmail($tweet);
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
