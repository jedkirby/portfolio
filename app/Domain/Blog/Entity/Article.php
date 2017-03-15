<?php

namespace App\Domain\Blog\Entity;

use Carbon\Carbon;

class Article
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var Carbon
     */
    private $date;

    /**
     * @var string
     */
    private $snippet;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $keywords = [];

    /**
     * @param string $title
     * @param Carbon $date
     * @param string $snippet
     * @param string $content
     * @param string $image
     * @param array $keywords
     */
    public function __construct(
        $title,
        Carbon $date,
        $snippet,
        $content,
        $image,
        array $keywords = []
    ) {
        $this->title = $title;
        $this->date = $date;
        $this->snippet = $snippet;
        $this->content = $content;
        $this->image = $image;
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getSnippet()
    {
        return $this->snippet;
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
    public function getImage()
    {
        return cached_asset($this->image);
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}
