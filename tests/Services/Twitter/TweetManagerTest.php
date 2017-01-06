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
     */
    public function itReturnAnInstanceOfTheCorrectClass()
    {
        return $this->assertInstanceOf(
            Tweet::class,
            $this->getTweet()
        );
    }

    /**
     * @test
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
     */
    public function itHasTheCorrectId()
    {
        return $this->assertEquals(
            $this->getTweet()->getId(),
            $this->tweetDetails['id']
        );
    }

    /**
     * @test
     */
    public function itHasTheCorrectRawText()
    {
        return $this->assertEquals(
            $this->getTweet()->getTextRaw(),
            $this->tweetDetails['text']
        );
    }

    /**
     * @test
     */
    public function itParsesTheTweetTextCorrectly()
    {
        return $this->assertEquals(
            $this->getTweet()->getText(),
            'This is the tweet text with a @<a href="https://twitter.com/mention" target="_blank">mention</a>, #<a href="https://twitter.com/hashtag/Hashtag" target="_blank">Hashtag</a>, and a link <a href="https://t.co/qeSnkprYiP" target="_blank">https://jedkirby.com</a>.'
        );
    }

    /**
     * @test
     */
    public function itHasTheCorrectRetweetCount()
    {
        return $this->assertEquals(
            $this->getTweet()->getRetweetCount(),
            $this->tweetDetails['retweet_count']
        );
    }

    /**
     * @test
     */
    public function itCorrectlyHasNoRetweets()
    {
        return $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasRetweets()
        );
    }

    /**
     * @test
     */
    public function itHasTheCorrectFavoriteCount()
    {
        return $this->assertEquals(
            $this->getTweet()->getFavoriteCount(),
            $this->tweetDetails['favorite_count']
        );
    }

    /**
     * @test
     */
    public function itCorrectlyHasNoFavorites()
    {
        return $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasFavorites()
        );
    }

    /**
     * @test
     */
    public function itHasTheCorrectLocation()
    {
        return $this->assertEquals(
            $this->getTweet()->getLocation(),
            $this->tweetDetails['place']['full_name']
        );
    }

    /**
     * @test
     */
    public function itCorrectlyHasNoLocation()
    {
        return $this->assertFalse(
            TweetManager::createFromArray([
                'id' => 1,
                'text' => 'Tweet Text!'
            ])->hasLocation()
        );
    }

    /**
     * @test
     */
    public function itBuildTheTweetUrlCorrectly()
    {
        return $this->assertEquals(
            $this->getTweet()->getLink(),
            Config::get('site.social.streams.twitter.url') . '/status/' . $this->tweetDetails['id']
        );
    }

}
