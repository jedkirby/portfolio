<?php

namespace App\Blog\Tags;

use App\Blog\Tags\AbstractTag;
use App\Blog\Contracts\Tag as TagContract;

/**
 * @codeCoverageIgnore
 */
class Nginx extends AbstractTag implements TagContract
{

    /**
     * @inherit
     */
    public function getName()
    {
        return 'Nginx';
    }

}
