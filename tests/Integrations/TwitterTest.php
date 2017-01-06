<?php

namespace Test\App\Integrtions;

use Config;
use App\Integrations\Twitter;
use App\Integrations\Twitter\Tweet;
use Test\App\AbstractTestCase;

class TwitterTest extends AbstractTestCase
{

    /**
     * Default tweet details.
     *
     * @var array
     */
    private $tweetDetails = [
        'id' => 1,
        'text' => 'This is the tweet text.',
        'retweet_count' => 123,
        'favorite_count' => 456,
        'place' => [
            'full_name' => 'Stratford Upon Avon, UK'
        ]
    ];

    /**
     * Return a tweet instance with the default details.
     *
     * @return Tweet
     */
    private function getTweet()
    {
        return Twitter::createFromArray($this->tweetDetails);
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
    public function itHasTheCorectText()
    {
        return $this->assertEquals(
            $this->getTweet()->getText(),
            $this->tweetDetails['text']
        );
    }

    /**
     * @test
     */
    public function itParsesTheTweetTextCorrectly()
    {

        $tweetInputText = 'This is a @user tweet.';
        $tweetExpectedText = 'This is a <a href="https://twitter.com/user" target="_blank">@user</a> tweet.';

        $tweetDetails = $this->tweetDetails;
        $tweetDetails['text'] = $tweetInputText;

        return $this->assertEquals(
            Twitter::createFromArray($tweetDetails)->getText(),
            $tweetExpectedText
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
            Twitter::createFromArray([
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
            Twitter::createFromArray([
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
            Twitter::createFromArray([
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
