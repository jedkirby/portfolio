<?php

namespace App\Console\Commands;

use App;
use Log;
use Mail;
use Config;
use App\Integrations\Twitter;
use Illuminate\Console\Command;
use App\Integrations\Twitter\Tweet;
use App\Integrations\Twitter\Connection;
use App\Integrations\Twitter\Exceptions\UnableToGetLatestTweetException;

class TwitterFeed extends Command
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
    protected $description = 'Fetch the latest twitter home timeline.';

    /**
     * @var Connection
     */
    protected $conn;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->conn = Connection::make();
    }

    /**
     * Return the home timeline feed for the user.
     *
     * @return array
     */
    private function getFeed()
    {

        $feed = [];
        $response = $this->conn->get(
            'statuses/user_timeline.json',
            [
                'auth' => 'oauth',
                'query' => [
                    'screen_name'         => Config::get('site.social.streams.twitter.name'),
                    'trim_user'           => true,
                    'exclude_replies'     => true,
                    'contributor_details' => false,
                    'include_rts'         => false
                ]
            ]
        );

        if (in_array($response->getStatusCode(), [200])) {
            $data = json_decode($response->getBody(), true);
            if ($data && is_array($data)) {
                $feed = $data;
            }
        }

        return $feed;

    }

    /**
     * Get the most relevant latest tweet.
     *
     * @throws UnableToGetLatestTweetException
     *
     * @return Tweet
     */
    private function getLatestTweet()
    {

        $allowedHashtags = Config::get('site.social.streams.twitter.hashtags', []);

        foreach ($this->getFeed() as $tweet) {
            foreach (array_get($tweet, 'entities.hashtags', []) as $hashtag) {
                if (in_array(strtolower(array_get($hashtag, 'text')), array_map('strtolower', $allowedHashtags))) {
                    return Twitter::createFromArray($tweet);
                }
            }
        }

        throw new UnableToGetLatestTweetException('No Relevant Tweet Found');

    }

    /**
     * Determine if the tweet has changed.
     *
     * @param Tweet $tweet
     *
     * @return boolean
     */
    private function hasTweetChanged(Tweet $tweet)
    {
        if (($storedTweet = Twitter::getTweet())) {
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
    private function sendChangedEmail(Tweet $tweet)
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
    public function fire()
    {

        try {

            $tweet = $this->getLatestTweet();

            if ($this->hasTweetChanged($tweet) && App::environment('production')) {
                $this->sendChangedEmail($tweet);
            }

            Twitter::setTweet($tweet);

        } catch (Exception $e) {
            Log::error($e);
        }

    }

}
