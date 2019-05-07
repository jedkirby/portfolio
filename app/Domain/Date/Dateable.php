<?php

namespace App\Domain\Date;

use Carbon\Carbon;

/**
 * @codeCoverageIgnore
 */
interface Dateable
{
    /**
     * @return Carbon
     */
    public function getDate();
}
