<?php

namespace App\Blog\Tags;

abstract class AbstractTag
{

    /**
     * Create a new instance of the tag.
     *
     * @return static
     */
    public static function make()
    {
        return new static;
    }

    /**
     * Return the name of the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}
