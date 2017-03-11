<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

final class BlitzTech implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'BlitzTech';
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
        return 'fa fa-cog';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2013, 2, 14);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.blitz-tech.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.blitz-tech.content');
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
            'Blitz',
            'Tech',
            'Technology',
            'Software',
            'Responsive',
            'Design',
            'Re-design',
            'CSS3',
            'HTML5',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/blitz-tech/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/blitz-tech/images/1.jpg'),
            cached_asset('assets/img/projects/blitz-tech/images/2.jpg'),
            cached_asset('assets/img/projects/blitz-tech/images/3.jpg'),
            cached_asset('assets/img/projects/blitz-tech/images/4.jpg'),
            cached_asset('assets/img/projects/blitz-tech/images/5.jpg'),
        ];
    }
}
