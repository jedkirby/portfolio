<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

final class AdminPanel implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Admin Panel';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Content Management';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-cogs';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2014, 11, 10);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.admin-panel.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.admin-panel.content');
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
        return false;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return [
            'CMS',
            'Content Management System',
            'Packages',
            'Laravel',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/admin-panel/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/admin-panel/images/1.jpg'),
            cached_asset('assets/img/projects/admin-panel/images/2.jpg'),
            cached_asset('assets/img/projects/admin-panel/images/3.jpg'),
            cached_asset('assets/img/projects/admin-panel/images/4.jpg'),
            cached_asset('assets/img/projects/admin-panel/images/5.jpg'),
        ];
    }
}
