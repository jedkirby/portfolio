<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class AMElectrical implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'A M Electrical';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Electrical Contractors';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-headphones';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2014, 10, 11);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.a-m-electrical.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.a-m-electrical.content');
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
        return 'http://a-m-electrical.com';
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
            'Aaron',
            'Middleton',
            'Electrical',
            'Electrician',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/a-m-electrical/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/a-m-electrical/images/1.jpg'),
            cached_asset('assets/img/projects/a-m-electrical/images/2.jpg'),
            cached_asset('assets/img/projects/a-m-electrical/images/3.jpg'),
            cached_asset('assets/img/projects/a-m-electrical/images/4.jpg'),
            cached_asset('assets/img/projects/a-m-electrical/images/5.jpg'),
            cached_asset('assets/img/projects/a-m-electrical/images/6.jpg'),
        ];
    }
}
