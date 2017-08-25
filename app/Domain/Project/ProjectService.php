<?php

namespace App\Domain\Project;

class ProjectService
{
    /**
     * Projects have now been removed from the site, so, best way is to just
     * list the project names and provide the count. They're in descending
     * order of completion.
     *
     * @return int
     */
    public static function getCompletedCount()
    {
        return count([
            'sparkler',
            'victoria-jeffs',
            'php-warwickshire',
            'a-m-electrical',
            'admin-panel',
            'shrek-alarm',
            'blitz-games',
            'vuven',
            'blitz-tech',
            'blitz-games-studios',
            'umberslade-adventure',
            'coca-cola',
            'well-forged-films',
        ]);
    }
}
