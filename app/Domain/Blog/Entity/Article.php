<?php

namespace App\Domain\Blog\Entity;

use Carbon\Carbon;

class Article
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
     * @param string $id
     * @param string $title
     * @param Carbon $date
     * @param string $snippet
     * @param string $content
     * @param string $image
     * @param array $keywords
     */
    public function __construct(
        $id,
        $title,
        Carbon $date,
        $snippet,
        $content,
        $image,
        array $keywords = []
    ) {
        $this->id = $id;
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
        return ($this->image ? cached_asset($this->image) : false);
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return url(sprintf(
            '/blog/%s',
            $this->getId()
        ));
    }
}
