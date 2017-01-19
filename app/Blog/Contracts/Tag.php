<?php

namespace App\Blog\Contracts;

interface Tag
{
    /**
     * Return the name of the tag.
     *
     * @return string
     */
    public function getName();
}
