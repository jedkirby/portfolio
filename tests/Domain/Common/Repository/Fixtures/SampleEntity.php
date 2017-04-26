<?php

namespace App\Tests\Domain\Common\Repository\Fixtures;

use App\Domain\Common\Entity\EntityInterface;

class SampleEntity implements EntityInterface
{
    private $id;

    private $title;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
