<?php

namespace App\Tests\Domain\Service\Twitter\Command;

use App\Domain\Service\Twitter\Command\LatestTweet;
use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\Jobs\SendTweetUpdate;
use App\Domain\Service\Twitter\TweetManager;
use App\Domain\Service\Twitter\TwitterService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;
use Config;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.command
 */
class LatestTweetTest extends TestCase
{
    public function testItRunsTheCommandCorrectly()
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
