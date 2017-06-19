<?php

namespace App\Domain\Work\Entity;

use App\Domain\Common\Entity\EntityInterface;
use Carbon\Carbon;

class Item implements EntityInterface
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
    private $intro;

    /**
     * @var string
     */
    private $hero;

    /**
     * @param string $id
     * @param string $title
     * @param Carbon $date
     * @param string $intro
     * @param string $hero
     */
    public function __construct(
        $id,
        $title,
        Carbon $date,
        $intro,
        $hero
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->intro = $intro;
        $this->hero = $hero;
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
}
