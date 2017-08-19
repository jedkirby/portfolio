<?php

namespace App\Domain\Date;

use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
class DateFormatter
{
    /**
     * @param Carbon $datetime
     *
     * @return string
     */
    public static function getForMeta(Carbon $datetime)
    {
        return $datetime->format('Y-m-d');
    }

    /**
     * @param Datetime $datetime
     *
     * @return string
     */
    public static function getForHuman(Carbon $datetime)
    {
        return $datetime->format('F j, Y');
    }
}
