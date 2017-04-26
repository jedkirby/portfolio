<?php

namespace App\Tests\Domain\Service\Twitter;

use App\Domain\Service\Twitter\Connection\Connection;
use App\Domain\Service\Twitter\Entity\Tweet;
use App\Domain\Service\Twitter\TweetManager;
use App\Domain\Service\Twitter\TwitterService;
use App\Tests\AbstractAppTestCase as TestCase;
use App\Tests\Domain\Service\Twitter\Connection\Provider\Fixtures\StaticContent as StaticContentProvider;
use Config;

/**
 * @group domain
 * @group domain.service
 * @group domain.service.twitter
 * @group domain.service.twitter.manager
 */
class TweetManagerTest extends TestCase
{
    private $manager;
    private $tweetDetails = [
        'id' => 12987913324876991,
        'text' => 'This is the tweet text with a @mention, #Hashtag, and a link https://t.co/qeSnkprYiP.',
        'entities' => [
            'hashtags' => [
                [
                    'text' => 'Hashtag',
                ],
            ],
            'user_mentions' => [
                [
                    'screen_name' => 'mention',
                ],
            ],
            'urls' => [
                [
                    'url' => 'https://t.co/qeSnkprYiP',
                    'display_url' => 'https://jedkirby.com',
                ],
            ],
        ],
        'retweet_count' => 123,
        'favorite_count' => 456,
        'place' => [
            'full_name' => 'Stratford Upon Avon, UK',
        ],
    ];

    public function setUp()
    {
        parent::setUp();
        $this->manager = new TweetManager();
    }

    private function getTweet()
    {
        return TweetManager::createFromArray($this->tweetDetails);
    }

    private function getService()
    {
        return new TwitterService(
            new Connection(
                new StaticContentProvider()
            )
        );
    }

    public function testItReturnsAnArrayOfAllowedHashtags()
    {
        $this->assertInternalType(
            'array',
            $this->manager->getAllowedHashtags()
        );
    }

    public function testItReturnAnInstanceOfTheCorrectClass()
    {
        $this->assertInstanceOf(
            Tweet::class,
            $this->getTweet()
        );
    }

    public function testItCanStoreAndGetTheTweetInMemory()
    {
        $tweet = $this->getTweet();

        $this->manager->setTweet($tweet);

        $storedTweet = $this->manager->getTweet();

        $this->assertEquals(
            $tweet->getId(),
            $storedTweet->getId()
        );

        $this->manager->clearCache();
    }

    public function testItHasTheCorrectId()
    {
        $this->assertEquals(
            $this->getTweet()->getId(),
            $this->tweetDetails['id']
        );
    }

    public function testItHasTheCorrectRawText()
    {
        $this->assertEquals(
            $this->getTweet()->getTextRaw(),
            $this->tweetDetails['text']
        );
    }

    public function testItParsesTheTweetTextCorrectly()
    {
        $this->assertEquals(
            $this->getTweet()->getText(),
            'This is the tweet text with a @<a href="https://twitter.com/mention" target="_blank">mention</a>, #<a href="https://twitter.com/hashtag/Hashtag" target="_blank">Hashtag</a>, and a link <a href="https://t.co/qeSnkprYiP" target="_blank">https://jedkirby.com</a>.'
        );
    }

    public function testItHasTheCorrectRetweetCount()
    {
        $this->assertEquals(
            $this->getTweet()->getRetweetCount(),
            $this->tweetDetails['retweet_count']
        );
    }

    public function testItCorrectlyHasNoRetweets()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!',
            ])->hasRetweets()
        );
    }

    public function testItHasTheCorrectFavoriteCount()
    {
        $this->assertEquals(
            $this->getTweet()->getFavoriteCount(),
            $this->tweetDetails['favorite_count']
        );
    }

    public function testItCorrectlyHasNoFavorites()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!',
            ])->hasFavorites()
        );
    }

    public function testItHasTheCorrectLocation()
    {
        $this->assertEquals(
            $this->getTweet()->getLocation(),
            $this->tweetDetails['place']['full_name']
        );
    }

    public function testItHasTheCorrectHashtags()
    {
        $this->assertEquals(
            $this->getTweet()->getHashtags(),
            $this->tweetDetails['entities']['hashtags']
        );
    }

    public function testItCorrectlyHasNoLocation()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!',
            ])->hasLocation()
        );
    }

    public function testItBuildTheTweetUrlCorrectly()
    {
        $this->assertEquals(
            $this->getTweet()->getLink(),
            Config::get('site.social.streams.twitter.url') . '/status/' . $this->tweetDetails['id']
        );
    }

    public function testItGetsTheCorrectLatestTweet()
    {
        $service = $this->getService();
        $timeline = $service->getConnection()->getTimeline();

        $tweet = $this->manager->getLatestTweet($timeline, ['Twitterbird']);

        $this->assertInstanceOf(
            Tweet::class,
            $tweet
        );

        $this->assertEquals(
            $tweet->getTextRaw(),
            "Along with our new #Twitterbird, we've also updated our Display Guidelines: https://t.co/Ed4omjYs"
        );
    }

    /**
     * @expectedException \App\Domain\Service\Twitter\Exception\UnableToGetLatestTweetException
     */
    public function testItThrowsAnExceptionWhenNoLatestTweetIsFound()
    {
        $service = $this->getService();
        $timeline = $service->getConnection()->getTimeline();

        $tweet = $this->manager->getLatestTweet($timeline, []);
    }

    public function testItCorrectlyKnowsWhenTheTweetHasChanged()
    {
        $storedTweet = TweetManager::createFromArray(['id' => 1, 'text' => 'Stored Tweet']);
        $newTweet = TweetManager::createFromArray(['id' => 2, 'text' => 'New Tweet']);

        $this->manager->setTweet($storedTweet);

        $this->assertTrue(
            $this->manager->hasTweetChanged($newTweet)
        );

        $this->manager->clearCache();
    }

    public function testItReportsTheTweetChangingWhenOneIsNotStored()
    {
        $tweet = TweetManager::createFromArray(['id' => 1, 'text' => 'Tweet']);

        $this->manager->clearCache();

        $this->assertTrue(
            $this->manager->hasTweetChanged($tweet)
        );
    }

    public function testItCorrectlyKnowsWhenTheTweetHasNotChanged()
    {
        $tweet = TweetManager::createFromArray(['id' => 1, 'text' => 'Tweet']);

        $this->manager->setTweet($tweet);

        $this->assertFalse(
            $this->manager->hasTweetChanged($tweet)
        );

        $this->manager->clearCache();
    }
}
