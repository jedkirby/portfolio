<?php

namespace App\Domain\Social;

use Illuminate\Contracts\Config\Repository as Config;
use SocialLinks\Page as BasePage;

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
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->info['title'] = $title;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->info['text'] = $text;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->info['image'] = $image;
    }

    /**
     * @param string $user
     */
    public function setTwitterUser($user)
    {
        $this->info['twitterUser'] = $user;
    }
}
