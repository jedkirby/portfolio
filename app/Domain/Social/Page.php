<?php

namespace App\Domain\Social;

use SocialLinks\Page as BasePage;
use Illuminate\Contracts\Config\Repository as Config;

class Page extends BasePage
{
    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->setTwitterUser(
            $config->get('site.social.streams.twitter.handle', '')
        );
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->info['url'] = $url;
    }

    /**
     * @param string $url
     */
    public function setTitle($title)
    {
        $this->info['title'] = $title;
    }

    /**
     * @param string $url
     */
    public function setText($text)
    {
        $this->info['text'] = $text;
    }

    /**
     * @param string $url
     */
    public function setImage($image)
    {
        $this->info['image'] = $image;
    }

    /**
     * @param string $url
     */
    public function setTwitterUser($user)
    {
        $this->info['twitterUser'] = $user;
    }
}
