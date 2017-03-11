<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class UmbersladeAdventure implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Umberslade Adventure';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Outdoor Adventures';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-paw';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2012, 9, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.umberslade-adventure.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.umberslade-adventure.content');
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
        return 'http://umbersladeadventure.com';
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
            'Outdoor Adventures',
            'Design',
            'Build',
            'HTML5',
            'CSS3',
            'Semantic Markup',
            'Adventure',
            'Playarea',
            'Children',
            'Days out',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/umberslade-adventure/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/umberslade-adventure/images/1.jpg'),
            cached_asset('assets/img/projects/umberslade-adventure/images/2.jpg'),
            cached_asset('assets/img/projects/umberslade-adventure/images/3.jpg'),
            cached_asset('assets/img/projects/umberslade-adventure/images/4.jpg'),
        ];
    }
}
