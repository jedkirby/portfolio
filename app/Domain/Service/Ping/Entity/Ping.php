<?php

namespace App\Domain\Service\Ping\Entity;

use DateTime;

class Ping
{
    /**
     * @var string
     */
    private $service;

    /**
     * @var DateTime
     */
    private $date;

    public function __construct()
    {
        $this->date = new DateTime();
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
