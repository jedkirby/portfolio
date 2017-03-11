<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class BlitzGamesStudios implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Blitz Games Studios';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Redesigned Home Page';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-trophy';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2012, 12, 19);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.blitz-games-studios.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.blitz-games-studios.content');
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
        return 'http://blitzgamesstudios.com';
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
            'Home Page',
            'Re-design',
            'Full Screen',
            'Interactive',
            'Dropdown Menu',
            'Responsive',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/blitz-games-studios/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/blitz-games-studios/images/1.jpg'),
            cached_asset('assets/img/projects/blitz-games-studios/images/2.jpg'),
        ];
    }
}
