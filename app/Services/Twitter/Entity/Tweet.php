<?php

namespace App\Services\Twitter\Entity;

use Config;
use Jedkirby\TweetEntityLinker\Tweet as TweetEntityLinker;

class Tweet
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $entities;

    /**
     * @var int
     */
    private $retweetCount;

    /**
     * @var int
     */
    private $favoriteCount;

    /**
     * @var array|bool
     */
    private $location;

    /**
     * {@inheritdoc}
     */
    private function __construct($id, $text, $entities, $retweetCount, $favoriteCount, $location)
    {
        $this->id = (int) $id;
        $this->text = (string) $text;
        $this->entities = (array) $entities;
        $this->retweetCount = (int) $retweetCount;
        $this->favoriteCount = (int) $favoriteCount;
        $this->location = $location;
    }

    /**
     * @param int $id
     * @param string $text
     * @param array $entities
     * @param int $retweetCount
     * @param int $favoriteCount
     * @param array|bool $location
     */
    public static function make($id, $text, $entities, $retweetCount = 0, $favoriteCount = 0, $location = false)
    {
        return new self($id, $text, $entities, $retweetCount, $favoriteCount, $location);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTextRaw()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return TweetEntityLinker::make(
            $this->text,
            $this->entities['urls'],
            $this->entities['user_mentions'],
            $this->entities['hashtags']
        )->linkify();
    }

    /**
     * @return int
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return array
     */
    public function getHashtags()
    {
        return array_get($this->entities, 'hashtags', []);
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return sprintf(
            '%s/status/%s',
            Config::get('site.social.streams.twitter.url'),
            $this->getId()
        );
    }

    /**
     * @return bool
     */
    public function hasLocation()
    {
        return (bool) $this->getLocation();
    }

    /**
     * @return bool
     */
    public function hasRetweets()
    {
        return (bool) $this->getRetweetCount();
    }

    /**
     * @return bool
     */
    public function hasFavorites()
    {
        return (bool) $this->getFavoriteCount();
    }
}
