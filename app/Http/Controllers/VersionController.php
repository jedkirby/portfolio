<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class VersionController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        dd(
            client_version()
        );
    }
}
