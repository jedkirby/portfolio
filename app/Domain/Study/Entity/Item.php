<?php

namespace App\Domain\Study\Entity;

use App\Domain\Common\Entity\EntityInterface;
use App\Domain\Common\KeywordGenerator;
use App\Domain\Date\Dateable;
use App\Domain\Date\DateFormats;
use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
class Item implements EntityInterface, Dateable
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
    private $intro;

    /**
     * @var string
     */
    private $hero;

    /**
     * @var array
     */
    private $keywords = [];

    /**
     * @param string $id
     * @param string $title
     * @param Carbon $date
     * @param string $intro
     * @param string $hero
     * @param array $keywords
     */
    public function __construct(
        $id,
        $title,
        Carbon $date,
        $intro,
        $hero,
        $keywords = []
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->intro = $intro;
        $this->hero = $hero;
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
    public function getIntro()
    {
        return $this->intro;
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
        return route(
            'study',
            $this->getId()
        );
    }
}
