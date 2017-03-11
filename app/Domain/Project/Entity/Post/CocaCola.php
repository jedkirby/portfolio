<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class CocaCola implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Coca-Cola Promotion';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'User Interface';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-hand-paper-o';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2012, 1, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.coca-cola.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.coca-cola.content');
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
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpired()
    {
        return 'This website is no longer available';
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return [
            'Coca Cola',
            'NFL',
            'Super Bowl',
            '46',
            '2012',
            'Promotion',
            'Interactive',
            'User Interface',
            'Software',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/coca-cola/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/coca-cola/images/1.jpg'),
            cached_asset('assets/img/projects/coca-cola/images/2.jpg'),
            cached_asset('assets/img/projects/coca-cola/images/3.jpg'),
            cached_asset('assets/img/projects/coca-cola/images/4.jpg'),
        ];
    }
}
