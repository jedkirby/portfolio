<?php

namespace App\Domain\Blog\Entity;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Common\KeywordGenerator;
use App\Domain\Date\Dateable;
use App\Domain\Date\DateFormats;
use Carbon\Carbon;

class Article implements EntityInterface, Dateable
{
    use DateFormats;

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
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
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
        return $this->image ? casset($this->image) : false;
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
    public function getKeywordsForMeta()
    {
        $generator = new KeywordGenerator(
            $this->getKeywords()
        );

        return $generator->run();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('article', $this->getId());
    }
}
