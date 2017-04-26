<?php

namespace App\Domain\Project\Entity;

use App\Domain\Common\Entity\EntityInterface;
use Carbon\Carbon;

class Post implements EntityInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var Carbon
     */
    private $date;

    /**
     * @var string
     */
    private $introduction;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $testimonial;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $expired;

    /**
     * @var string
     */
    private $hero;

    /**
     * @var array
     */
    private $keywords = [];

    /**
     * @var array
     */
    private $images = [];

    /**
     * @param string $id
     * @param string $title
     * @param string $subtitle
     * @param string $icon
     * @param Carbon $date
     * @param string $introduction
     * @param string $content
     * @param string $testimonial
     * @param string $link
     * @param string $expired
     * @param string $hero
     * @param array $keywords
     * @param array $images
     */
    public function __construct(
        $id,
        $title,
        $subtitle,
        $icon,
        Carbon $date,
        $introduction,
        $content,
        $testimonial,
        $link,
        $expired,
        $hero,
        array $keywords = [],
        array $images = []
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;
        $this->date = $date;
        $this->introduction = $introduction;
        $this->content = $content;
        $this->testimonial = $testimonial;
        $this->link = $link;
        $this->expired = $expired;
        $this->hero = $hero;
        $this->keywords = $keywords;
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getDate($format = 'Y-m-d')
    {
        return $this->date->format($format);
    }

    /**
     * @return string
     */
    public function getIntroduction()
    {
        return view($this->introduction);
    }

    /**
     * @return string
     */
    public function getIntroductionForMeta()
    {
        return strip_tags($this->getIntroduction());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return view($this->content);
    }

    /**
     * @return string
     */
    public function getTestimonial()
    {
        return $this->testimonial;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @return string
     */
    public function getHero()
    {
        return casset($this->hero);
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[] = casset($image);
        }

        return $images;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('project', $this->getId());
    }
}
