<?php

namespace App\Http\Controllers;

class CookiePolicyController extends AbstractController
{
    /**
     * {@inheritdoc}.
     */
    public function __invoke()
    {
        return view(
            'pages.policy.cookie',
            $this->getViewParams([
                'title' => 'Cookie Policy',
            ])
        );
    }
}
