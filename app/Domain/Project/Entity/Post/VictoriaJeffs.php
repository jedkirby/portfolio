<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class VictoriaJeffs implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Victoria Jeffs';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Estate Agent';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-home';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2015, 1, 5);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.victoria-jeffs.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.victoria-jeffs.content');
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
        return 'http://victoriajeffs.co.uk';
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
            'Victoria',
            'Jeffs',
            'Content Management System',
            'CMS',
            'Property',
            'Estate Agent',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/victoria-jeffs/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/victoria-jeffs/images/1.jpg'),
            cached_asset('assets/img/projects/victoria-jeffs/images/2.jpg'),
            cached_asset('assets/img/projects/victoria-jeffs/images/3.jpg'),
            cached_asset('assets/img/projects/victoria-jeffs/images/4.jpg'),
        ];
    }
}
