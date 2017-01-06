<?php

namespace Test\App\Services\Twitter;

use Config;
use Test\App\AbstractTestCase;
use App\Services\Twitter\Tweet;
use GuzzleHttp\Client as GuzzleClient;
use App\Services\Twitter\TwitterConnection;

class TwitterConnectionTest extends AbstractTestCase
{

    /**
     * @return TwitterConnection
     */
    private function getConnection()
    {
        return new TwitterConnection(
            $_ENV['TWITTER_CONSUMER_KEY'],
            $_ENV['TWITTER_CONSUMER_SECRET'],
            $_ENV['TWITTER_TOKEN'],
            $_ENV['TWITTER_TOKEN_SECRET']
        );
    }

    /**
     * @test
     * @group twitter
     * @group twitter.connection
     */
    public function itCreatesTheGuzzleClientProperly()
    {
        return $this->assertInstanceOf(
            GuzzleClient::class,
            $this->getConnection()->getClient()
        );
    }

    /**
     * @test
     * @group twitter
     * @group twitter.connection
     */
    public function itCanGetTheTimelineCorrectly()
    {

        Config::set('site.social.streams.twitter.limit', 2); // Reduce the limit for speed

        $timeline = $this->getConnection()->getTimeline();

        $this->assertInternalType(
            'array',
            $timeline
        );

        $this->assertGreaterThan(
            0,
            count($timeline)
        );

        foreach ($timeline as $tweet) {
            $this->assertInstanceOf(
                Tweet::class,
                $tweet
            );
        }

    }

    /**
     * @test
     * @group twitter
     * @group twitter.connection
     */
    public function itReturnsAnEmptyArrayForFailure()
    {

        Config::set('site.social.streams.twitter.name', '--'); // Override the user to be invalid

        $timeline = $this->getConnection()->getTimeline();

        $this->assertInternalType(
            'array',
            $timeline
        );

        $this->assertEmpty($timeline);

    }

    /**
     * @test
     * @group twitter
     * @group twitter.connection
     */
    public function itCanGetTheTweetById()
    {

        $tweet = $this->getConnection()->getTweetById(806846890180575232);

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );

    }

    /**
     * @test
     * @group twitter
     * @group twitter.connection
     */
    public function itReturnsFalseForNoneExistentTweet()
    {
        $this->assertFalse(
            $this->getConnection()->getTweetById('--')
        );
    }

}
