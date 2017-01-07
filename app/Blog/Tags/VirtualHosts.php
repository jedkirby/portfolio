<?php

namespace App\Blog\Tags;

use App\Blog\Contracts\Tag as TagContract;

/**
 * @codeCoverageIgnore
 */
class VirtualHosts extends AbstractTag implements TagContract
{
    /**
     * @inherit
     */
    public function getName()
    {
        return 'Virtual Hosts';
    }
}
