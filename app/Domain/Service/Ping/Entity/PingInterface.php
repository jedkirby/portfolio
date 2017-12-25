<?php

namespace App\Domain\Service\Ping\Entity;

use Illuminate\Http\Request;

interface PingInterface
{
    /**
     * Populate the entity with specifcs from the request.
     *
     * @param Request $request
     */
    public function fromRequest(Request $request);
}
