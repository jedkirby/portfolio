<?php

namespace App\Integrations\Twitter;

use Config;
use Twitter;

class Tweet
{

    /**
     * Tweet Data.
     */
    private $id;
    private $text;
    private $retweetCount;
    private $favoriteCount;
    private $location;

    /**
     * Constructor.
     */
    private function __construct($id, $text, $retweetCount, $favoriteCount, $location)
    {
        $this->id = (int) $id;
        $this->text = (string) $text;
        $this->retweetCount = (int) $retweetCount;
        $this->favoriteCount = (int) $favoriteCount;
        $this->location = $location;
    }

    /**
     * Make command used for chaining.
     *
     * @param int $id
     * @param string $text
     * @param int $retweetCount
     * @param int $favoriteCount
     * @param boolean|string $location
     * @return Tweet
     */
    public static function make($id, $text, $retweetCount = 0, $favoriteCount = 0, $location = false)
    {
        return new self($id, $text, $retweetCount, $favoriteCount, $location);
    }

    /**
     * Return the ID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return, and parse, the text.
     *
     * @return string
     */
    public function getText()
    {
        return Twitter::linkify($this->text);
    }

    /**
     * Return the number of times it's been retweeted.
     *
     * @return int
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * Return the number of times it's been favorited.
     *
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * Get the location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Build a link to the tweet.
     *
     * @return string
     */
    public function getLink()
    {
        return Config::get('site.social.streams.twitter.url') . '/status/' . $this->getId();
    }

    /**
     * Check whether a location is visible.
     *
     * @return boolean
     */
    public function hasLocation()
    {
        return (bool) $this->getLocation();
    }

    /**
     * Check whether there are retweets.
     *
     * @return boolean
     */
    public function hasRetweets()
    {
        return (bool) $this->getRetweetCount();
    }

    /**
     * Check whether there are favorites.
     *
     * @return boolean
     */
    public function hasFavorites()
    {
        return (bool) $this->getFavoriteCount();
    }

}
