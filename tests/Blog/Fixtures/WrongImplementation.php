<?php

namespace App\Tests\Blog\Fixtures;

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
