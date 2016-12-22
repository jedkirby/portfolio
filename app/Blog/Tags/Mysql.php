<?php

namespace App\Blog\Tags;

use App\Blog\Tags\Tag as AbstractTag;
use App\Blog\Contracts\Tag as TagContract;

class Mysql extends AbstractTag implements TagContract
{

    /**
     * @inherit
     */
    public function getName()
    {
        return 'MySQL';
    }

}
