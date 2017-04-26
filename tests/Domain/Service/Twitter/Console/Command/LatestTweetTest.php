<?php

namespace App\Tests\Domain\Service\Twitter\Console\Command;

use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Console\Command\LatestTweet;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\Jobs\SendTweetUpdate;
use App\Domain\Service\Twitter\TweetManager;
use App\Domain\Service\Twitter\TwitterService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;
use Config;
use Illuminate\Contracts\Foundation\Application;
use Mockery;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.console
 * @group domain.service.twitter.console.command
 */
class LatestTweetTest extends TestCase
{
    private $application;
    private $manager;
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->application = Mockery::mock(Application::class);
        $this->service = new TwitterService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    public function testEmailIsNotSentForNoneProductionEnvs()
    {
        $manager = Mockery::mock(
            TweetManager::class,
            [
                'getAllowedHashtags' => ['Twitterbird'],
                'getLatestTweet' => Mockery::mock(Tweet::class),
                'hasTweetChanged' => true,
                'setTweet' => true,
            ]
        );

        $command = new LatestTweet(
            $this->application,
            $this->service,
            $manager
        );

        $this->application
            ->shouldReceive('environment')
            ->andReturn(false)
            ->once();

        $this->doesntExpectJobs(SendTweetUpdate::class);

        $command->handle();
    }

    public function testEmailIsSentForProduction()
    {
        $manager = Mockery::mock(
            TweetManager::class,
            [
                'getAllowedHashtags' => ['Twitterbird'],
                'getLatestTweet' => Mockery::mock(Tweet::class),
                'hasTweetChanged' => true,
                'setTweet' => true,
            ]
        );

        $command = new LatestTweet(
            $this->application,
            $this->service,
            $manager
        );

        $this->application
            ->shouldReceive('environment')
            ->andReturn(true)
            ->once();

        $this->expectsJobs(SendTweetUpdate::class);

        $command->handle();
    }

    public function testItRunsTheCommandCorrectly()
    {
        Config::set('site.social.streams.twitter.hashtags', ['Twitterbird']);

        $manager = new TweetManager();
        $command = new LatestTweet(
            $this->application,
            $this->service,
            $manager
        );

        $this->application
            ->shouldReceive('environment')
            ->andReturn(true)
            ->once();

        $manager->clearCache();

        $this->assertFalse(
            $manager->getTweet()
        );

        $this->expectsJobs(SendTweetUpdate::class);

        $command->handle();

        $tweet = $manager->getTweet();

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );

        $this->assertEquals(
            $tweet->getTextRaw(),
            "Along with our new #Twitterbird, we've also updated our Display Guidelines: https://t.co/Ed4omjYs"
        );

        $manager->clearCache();
    }
}
