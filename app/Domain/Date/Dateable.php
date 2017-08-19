<?php

namespace App\Domain\Date;

use Carbon\Carbon;

interface Dateable
{
    /**
     * @return Carbon
     */
    public function getDate();
}
