<?php

namespace App\Blog\Tags;

use App\Blog\Tags\AbstractTag;
use App\Blog\Contracts\Tag as TagContract;

class Games extends AbstractTag implements TagContract
{

    /**
     * @inherit
     */
    public function getName()
    {
        return 'Games';
    }

}
