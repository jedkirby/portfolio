<?php

namespace Test\App\Services\Twitter;

use Config;
use Test\App\AbstractTestCase;
use App\Services\Twitter\Tweet;
use App\Services\Twitter\TweetManager;

class TweetManagerTest extends AbstractTestCase
{

    /**
     * @var array
     */
    private $tweetDetails = [
        'id' => 12987913324876991,
        'text' => 'This is the tweet text with a @mention, #Hashtag, and a link https://t.co/qeSnkprYiP.',
        'entities' => [
            'hashtags' => [
                [
                    'text' => 'Hashtag'
                ]
            ],
            'user_mentions' => [
                [
                    'screen_name' => 'mention'
                ]
            ],
            'urls' => [
                [
                    'url' => 'https://t.co/qeSnkprYiP',
                    'display_url' => 'https://jedkirby.com'
                ]
            ]
        ],
        'retweet_count' => 123,
        'favorite_count' => 456,
        'place' => [
            'full_name' => 'Stratford Upon Avon, UK'
        ]
    ];

    /**
     * @return Tweet
     */
    private function getTweet()
    {
        return TweetManager::createFromArray($this->tweetDetails);
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnsAnArrayOfAllowedHashtags()
    {
        $this->assertInternalType(
            'array',
            TweetManager::getAllowedHashtags()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itReturnAnInstanceOfTheCorrectClass()
    {
        $this->assertInstanceOf(
            Tweet::class,
            $this->getTweet()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itCanStoreAndGetTheTweetInMemory()
    {

        $tweet = $this->getTweet();

        TweetManager::setTweet($tweet);

        $storedTweet = TweetManager::getTweet();

        $this->assertEquals(
            $tweet->getId(),
            $storedTweet->getId()
        );

        TweetManager::clearCache();

    }


    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectId()
    {
        $this->assertEquals(
            $this->getTweet()->getId(),
            $this->tweetDetails['id']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectRawText()
    {
        $this->assertEquals(
            $this->getTweet()->getTextRaw(),
            $this->tweetDetails['text']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itParsesTheTweetTextCorrectly()
    {
        $this->assertEquals(
            $this->getTweet()->getText(),
            'This is the tweet text with a @<a href="https://twitter.com/mention" target="_blank">mention</a>, #<a href="https://twitter.com/hashtag/Hashtag" target="_blank">Hashtag</a>, and a link <a href="https://t.co/qeSnkprYiP" target="_blank">https://jedkirby.com</a>.'
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectRetweetCount()
    {
        $this->assertEquals(
            $this->getTweet()->getRetweetCount(),
            $this->tweetDetails['retweet_count']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itCorrectlyHasNoRetweets()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasRetweets()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectFavoriteCount()
    {
        $this->assertEquals(
            $this->getTweet()->getFavoriteCount(),
            $this->tweetDetails['favorite_count']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itCorrectlyHasNoFavorites()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasFavorites()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectLocation()
    {
        $this->assertEquals(
            $this->getTweet()->getLocation(),
            $this->tweetDetails['place']['full_name']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itHasTheCorrectHashtags()
    {
        $this->assertEquals(
            $this->getTweet()->getHashtags(),
            $this->tweetDetails['entities']['hashtags']
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itCorrectlyHasNoLocation()
    {
        $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasLocation()
        );
    }

    /**
     * @test
     * @group twitter
     */
    public function itBuildTheTweetUrlCorrectly()
    {
        $this->assertEquals(
            $this->getTweet()->getLink(),
            Config::get('site.social.streams.twitter.url') . '/status/' . $this->tweetDetails['id']
        );
    }

}
