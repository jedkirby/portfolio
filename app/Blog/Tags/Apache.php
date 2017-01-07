<?php

namespace App\Blog\Tags;

use App\Blog\Contracts\Tag as TagContract;

/**
 * @codeCoverageIgnore
 */
class Apache extends AbstractTag implements TagContract
{
    /**
     * @inherit
     */
    public function getName()
    {
        return 'Apache';
    }
}
