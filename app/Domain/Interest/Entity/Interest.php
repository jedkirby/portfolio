<?php

namespace App\Domain\Interest\Entity;

use App\Domain\Common\Entity\EntityInterface;
use DateTime;

class Interest implements EntityInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var DateTime|null
     */
    private $datetime;

    /**
     * @var string
     */
    private $ip = 'N/A';

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Datetime|null
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param Datetime $datetime
     */
    public function setDatetime(Datetime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }
}
