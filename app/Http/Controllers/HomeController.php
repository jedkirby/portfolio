<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Service\Twitter\TweetManager as Twitter;

class HomeController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var Twitter
     */
    private $twitter;

    /**
     * @param Domain $domain
     * @param Twitter $twitter
     */
    public function __construct(
        Domain $domain,
        Twitter $twitter
    ) {
        $this->domain = $domain;
        $this->twitter = $twitter;
    }

    /**
     * {@inheritdoc}.
     */
    public function __invoke()
    {
        $this->domain->setDescription('Website and application developer based in Stratford Upon Avon, UK. An avid blogger of anything related to social media, business, entertainment or technology. Primarily covering Warwickshire, but expanding to the rest of the world to provide a stress free and professional service. Available for hire.');

        return view(
            'pages.home',
            $this->getViewParams([
                'tweet' => $this->twitter->getTweet(),
                'articles' => BlogController::articles(2),
                'projects' => ProjectController::projects(3),
            ])
        );
    }
}
