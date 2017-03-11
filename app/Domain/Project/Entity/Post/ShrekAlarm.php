<?php

namespace App\Domain\Project\Entity\Post;

use App\Domain\Project\Entity\PostInterface;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
final class ShrekAlarm implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Shrek Alarm';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return 'Mobile Application';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'fa fa-clock-o';
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return Carbon::createFromDate(2013, 8, 8);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntroduction()
    {
        return view('pages.projects.projects.shrek-alarm.intro');
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return view('pages.projects.projects.shrek-alarm.content');
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
        return 'This application and website is no longer available';
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return [
            'Shrek',
            'DreamWorks',
            'Alarm Clock',
            'Wake Up',
            'iOS',
            'Apple',
            'iPhone',
            'Android',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getHero()
    {
        return cached_asset('assets/img/projects/shrek-alarm/hero.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function getImages()
    {
        return [
            cached_asset('assets/img/projects/shrek-alarm/images/1.jpg'),
            cached_asset('assets/img/projects/shrek-alarm/images/2.jpg'),
        ];
    }
}
