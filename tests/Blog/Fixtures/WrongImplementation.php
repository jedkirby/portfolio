<?php

namespace Test\App\Blog\Fixtures;

use App\Blog\Tags\AbstractTag;

class WrongImplementation extends AbstractTag
{
    /**
     * @inherit
     */
    public function getName()
    {
        return 'Wrong Implementation';
    }
}
