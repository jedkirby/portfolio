<?php

namespace Test\App\Console\Commands;

use Config;
use Artisan;
use Test\App\AbstractTestCase;
use App\Services\Twitter\Tweet;
use App\Console\Commands\LatestTweet;
use App\Services\Twitter\TweetManager;
use App\Services\Twitter\TwitterService;
use Test\App\Services\Twitter\Connections\StaticConnection;

class LatestTweetTest extends AbstractTestCase
{

    /**
     * @test
     * @group twitter
     */
    public function itTest()
    {

        Config::set('site.social.streams.twitter.hashtags', ['Hashtag']);

        $manager = new TweetManager();
        $service = new TwitterService(
            new StaticConnection()
        );
        ;

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
