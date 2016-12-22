<?php

namespace App\Jobs;

use Log;
use Config;
use App\Jobs\Job;
use App\Integrations\Twitter;
use App\Integrations\Twitter\Tweet;
use App\Integrations\Twitter\Connection as TwitterConnection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchTwitterFeed extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue;

    /**
     * HTTP Client.
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * Return the home timeline feed for the user.
     *
     * @return array
     */
    private function getFeed()
    {

        $feed = [];
        $response = $this->client->get(
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
     * Return a single tweet using it's ID.
     *
     * @param  int $id
     * @return array
     */
    private function getTweetById($id)
    {

        $tweet = false;
        $response = $this->client->get(
            'statuses/show.json',
            [
                'auth' => 'oauth',
                'query' => [
                    'id'                 => $id,
                    'trim_user'          => true,
                    'include_my_retweet' => false,
                    'include_entities'   => false
                ]
            ]
        );

        if (in_array($response->getStatusCode(), [200])) {
            $data = json_decode($response->getBody(), true);
            if ($data && is_array($data)) {
                $tweet = $data;
            }
        }

        return $tweet;

    }

    /**
     * Search through feed to find the first relevent hashtagged tweet.
     *
     * @param  array $feed
     * @return array|boolean
     */
    private function pluckReleventTweet(array $feed)
    {

        $allowedHashtags = Config::get('site.social.streams.twitter.hashtags', []);
        $allowedHashtags = ['PlanetEarthTwo'];

        foreach ($feed as $tweet) {
            foreach (array_get($tweet, 'entities.hashtags', []) as $hashtag) {
                if (in_array(strtolower(array_get($hashtag, 'text')), array_map('strtolower', $allowedHashtags))) {
                    return $tweet;
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
        if (($previousTweet = Twitter::getLatest())) {
            return ($previousTweet->getId() !== $tweet->getId());
        }
        return true;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $tweet = false;
        $connection = new TwitterConnection(
            Config::get('site.social.streams.twitter.api.consumer_key'),
            Config::get('site.social.streams.twitter.api.consumer_secret'),
            Config::get('site.social.streams.twitter.api.token'),
            Config::get('site.social.streams.twitter.api.token_secret')
        );

        $this->client = $connection->getClient();

        $storedTweet = false;
        // $storedTweet = Twitter::getLatest();
        // $storedTweet = Twitter::createTweetFromArray(['id' => 797891901621833728, 'text' => "It's that time again .. #PlanetEarthTwo", 'retweet_count' => 567, 'favorite_count' => 0]);
        if ($storedTweet) {
            $tweetData = $this->getTweetById($storedTweet->getId());
            if ($tweetData) {
                $tweet = Twitter::createTweetFromArray($tweetData);
            }
        }

        if ($tweet) {
            Twitter::storeTweet($tweet);
        } else {
            $feed = $this->getFeed();
            if (($tweetData = $this->pluckReleventTweet($feed))) {
                $tweet = Twitter::createTweetFromArray($tweet);
                dd($tweetData);

            }
        }

    }

}
