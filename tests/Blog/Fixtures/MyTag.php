<?php

namespace Test\App\Blog\Fixtures;

use App\Blog\Tags\AbstractTag;
use App\Blog\Contracts\Tag as TagContract;

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
