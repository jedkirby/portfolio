<?php

namespace App\Http\Controllers;

class PrivacyPolicyController extends AbstractController
{
    /**
     * {@inheritdoc}.
     */
    public function __invoke()
    {
        return view(
            'pages.policy.privacy',
            $this->getViewParams([
                'title' => 'Privacy Policy',
            ])
        );
    }
}
