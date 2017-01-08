<?php

namespace App\Tests\Blog\Fixtures;

use App\Blog\Contracts\Tag as TagContract;
use App\Blog\Tags\AbstractTag;

class MyTag extends AbstractTag implements TagContract
{
    /**
     * @inherit
     */
    public function getName()
    {
        return 'My Tag';
    }
}
