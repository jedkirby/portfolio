<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

final class Vuven implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Vuven';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Rebrand';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-database';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2013, 4, 11);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.vuven.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.vuven.content');
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
        return 'http://vuven.com';
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
            'Vuven',
            'Website',
            'Development',
            'Design',
            'Applications',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/vuven/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/vuven/images/1.jpg'),
            cached_asset('assets/img/projects/vuven/images/2.jpg'),
            cached_asset('assets/img/projects/vuven/images/3.jpg'),
        ];
    }
}
