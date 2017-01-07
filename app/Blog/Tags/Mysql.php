<?php

namespace App\Blog\Tags;

use App\Blog\Tags\AbstractTag;
use App\Blog\Contracts\Tag as TagContract;

/**
 * @codeCoverageIgnore
 */
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
