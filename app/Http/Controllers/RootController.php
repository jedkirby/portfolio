<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class RootController extends BaseController
{
    /**
     * Setup the base controller.
     */
    public function __construct()
    {
        $this->setTitle(\Config::get('site.meta.title'));
        $this->setDescription('');
        $this->setKeywords(\Config::get('site.meta.keywords'));
        $this->setId(static::buildId());

        $this->setViewData('twitterHandle', \Config::get('site.social.streams.twitter.handle'));
        $this->setViewData('facebookId', \Config::get('site.social.streams.facebook.id'));
    }

    /**
     * Build an id based on the segements of the url.
     *
     * @return string
     */
    protected static function buildId()
    {
        return \Request::segment(1) ?: 'home';
    }

    /**
     * Set a meta data value.
     *
     * @param string $key
     * @param string $value
     */
    public function setViewData($key, $value)
    {
        \View::share($key, $value);
    }

    /**
     * Helper: Set the page title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->setViewData('title', $title);
    }

    /**
     * Helper: Set the page description.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->setViewData('description', $description);
    }

    /**
     * Helper: Set the page keywords.
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->setViewData('keywords', $keywords);
    }

    /**
     * Helper: Set the page id.
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->setViewData('pageid', $id);
    }
}
