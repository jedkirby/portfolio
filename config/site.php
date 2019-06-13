<?php

return [
    /*
     * Meta details
     */
    'meta' => [
        'author' => 'James Kirby',
        'title' => 'James Kirby',
        'keywords' => 'james, kirby, website, developer, php, laravel, javascipt, leamington, leamington spa',
        'telephone' => env('USER_META_TELEPHONE'),
        'email' => [
            'to' => env('USER_META_EMAIL_TO'),
            'from' => env('USER_META_EMAIL_FROM'),
        ],
    ],

    /*
     * Google Analytics Account ID, normally in this
     * format: "UA-123456-12". Leave this field blank
     * if there is to be no tracking enabled on this site.
     */
    'ga' => [
        'account' => env('GOOGLE_ANALYTICS_ID'),
    ],

    /*
     * Master social details
     */
    'social' => [
        'visible' => ['twitter', 'github', 'instagram', 'linkedin'],
        'streams' => [
            'twitter' => [
                'title' => 'Twitter',
                'url' => 'https://twitter.com/jedkirby',
                'id' => 70437719,
                'name' => 'jedkirby',
                'icon' => 'fa fa-twitter',
                'handle' => '@jedkirby',
                'api' => [
                    'consumer_key' => env('TWITTER_CONSUMER_KEY'),
                    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
                    'token' => env('TWITTER_TOKEN'),
                    'token_secret' => env('TWITTER_TOKEN_SECRET'),
                ],
                'hashtags' => explode('|', env('TWITTER_HASHTAGS', '')),
            ],
            'facebook' => [
                'title' => 'Facebook',
                'url' => 'https://facebook.com/jedkirby-info',
                'id' => 732500050,
                'name' => 'jedkirby-info',
                'icon' => 'fa fa-facebook',
            ],
            'github' => [
                'title' => 'GitHub',
                'url' => 'https://github.com/jedkirby',
                'name' => 'jedkirby',
                'icon' => 'fa fa-github',
            ],
            'linkedin' => [
                'title' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/in/jedkirby',
                'name' => 'jedkirby',
                'icon' => 'fa fa-linkedin',
            ],
            'instagram' => [
                'title' => 'Instagram',
                'url' => 'https://instagram.com/jedkirby',
                'id' => 9295963,
                'name' => 'jedkirby',
                'icon' => 'fa fa-instagram',
                'api' => [
                    'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),
                ],
                'ignore' => explode('|', env('INSTAGRAM_IGNORE', '')),
            ],
        ],
    ],

    /*
     * Typekit Kid ID
     */
    'typekit' => env('TYPEKIT_KIT_ID'),
];
