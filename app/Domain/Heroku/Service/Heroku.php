<?php

namespace App\Domain\Heroku\Service;

use Illuminate\Http\Request;

/**
 * @codeCoverageIgnore
 */
class Heroku
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getProxyIps(Request $request): array
    {
        return $request->getClientIps();
    }
}
