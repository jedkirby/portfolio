<?php

namespace Test\App\Services\Twitter\Commands;

use App\Services\Twitter\Commands\LatestTweet;
use App\Services\Twitter\Jobs\SendTweetUpdate;
use App\Services\Twitter\Entity\Tweet;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;
use Config;
use Test\App\AbstractTestCase;
use Test\App\Services\Twitter\Connections\StaticConnection;

class LatestTweetTest extends AbstractTestCase
{
    /**
     * @test
     * @group twitter
     */
    public function itRunsTheCommandCorrectly()
    {
        Config::set('site.social.streams.twitter.hashtags', ['Hashtag']);

        $this->expectsJobs(SendTweetUpdate::class);

        $manager = new TweetManager();
        $service = new TwitterService(
            new StaticConnection()
        );

        $this->assertFalse(
            $manager::getTweet()
        );

        (new LatestTweet($service, $manager))->handle();

        $tweet = $manager::getTweet();

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );

        $this->assertEquals(
            $tweet->getTextRaw(),
            'First Tweet with #Hashtag'
        );
    }
}
