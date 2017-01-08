<?php

namespace App\Services\Twitter\Connections\Providers;

/**
 * @codeCoverageIgnore
 */
interface ProviderInterface
{
    /**
     * Return a users home timeline.
     *
     * @return bool|array[]
     */
    public function getTimeline();

    /**
     * Return a single tweet by it's ID.
     *
     * @param int $id
     *
     * @return bool|array
     */
    public function getTweetById($id);
}
