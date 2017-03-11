<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class WellForgedFilms implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Well Forged Films';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Movie Portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-video-camera';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2011, 12, 21);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.well-forged-films.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.well-forged-films.content');
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
            'Film',
            'Well Forged',
            'Production Company',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/well-forged-films/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/well-forged-films/images/1.jpg'),
            cached_asset('assets/img/projects/well-forged-films/images/2.jpg'),
            cached_asset('assets/img/projects/well-forged-films/images/3.jpg'),
        ];
    }
}
