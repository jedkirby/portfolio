<?php

namespace App\Tests\Services\Twitter\Commands;

use App\Services\Twitter\Commands\LatestTweet;
use App\Services\Twitter\Connections\Connection;
use App\Services\Twitter\Entity\Tweet;
use App\Services\Twitter\Jobs\SendTweetUpdate;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;
use App\Tests\AbstractAppTestCase;
use App\Tests\Services\Twitter\Connections\Providers\Fixtures\StaticContent as StaticContentProvider;
use Config;

class LatestTweetTest extends AbstractAppTestCase
{
    /**
     * @test
     * @group twitter
     */
    public function itRunsTheCommandCorrectly()
    {
        Config::set('site.social.streams.twitter.hashtags', ['Twitterbird']);

        $this->expectsJobs(SendTweetUpdate::class);

        $manager = new TweetManager();
        $service = new TwitterService(
            new Connection(
                new StaticContentProvider()
            )
        );

        $manager::clearCache();

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
            "Along with our new #Twitterbird, we've also updated our Display Guidelines: https://t.co/Ed4omjYs"
        );

        $manager::clearCache();
    }
}
