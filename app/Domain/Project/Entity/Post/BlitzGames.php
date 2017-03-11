<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

final class BlitzGames implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Blitz Games';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Responsive Design';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-gamepad';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2013, 6, 12);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.blitz-games.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.blitz-games.content');
    }

    /**
     * {@inheritdoc}
     */
    public function getTestimonial()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        return 'http://blitzgames.com';
    }

    /**
     * {@inheritdoc}
     */
    public function getExpired()
    {
        return false;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return [
            'Blitz',
            'Games',
            'Responsive',
            'UX',
            'SEO',
            'CodeIgniter',
            'Portfolio',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/blitz-games/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/blitz-games/images/1.jpg'),
            cached_asset('assets/img/projects/blitz-games/images/2.jpg'),
            cached_asset('assets/img/projects/blitz-games/images/3.jpg'),
            cached_asset('assets/img/projects/blitz-games/images/4.jpg'),
        ];
    }
}
