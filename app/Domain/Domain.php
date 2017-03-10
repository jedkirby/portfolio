<?php

namespace App\Domain;

use Illuminate\Contracts\Config\Repository as Config;

class Domain
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var string
     */
    private $author;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->title = $config->get('site.meta.title', '');
        $this->description = $config->get('site.meta.description', '');
        $this->keywords = $config->get('site.meta.keywords', '');
        $this->author = $config->get('site.meta.author', '');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array|string $keywords
     */
    public function setKeywords($keywords)
    {
        if (is_array($keywords)) {
            $keywords = implode(', ', $keywords);
        }

        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
}
