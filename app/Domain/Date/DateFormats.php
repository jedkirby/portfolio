<?php

namespace App\Domain\Date;

/**
 * @codeCoverageIgnore
 */
trait DateFormats
{
    /**
     * @return string
     */
    public function getDateForMeta()
    {
        return DateFormatter::getForMeta(
            $this->getDate()
        );
    }

    /**
     * @return string
     */
    public function getDateForHuman()
    {
        return DateFormatter::getForHuman(
            $this->getDate()
        );
    }
}
