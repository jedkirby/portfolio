<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\ProjectManager as Projects;
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
     * @var Projects
     */
    private $projects;

    /**
     * @param Domain $domain
     * @param Twitter $twitter
     * @param Projects $projects
     */
    public function __construct(
        Domain $domain,
        Twitter $twitter,
        Projects $projects
    ) {
        $this->domain = $domain;
        $this->twitter = $twitter;
        $this->projects = $projects;
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
                'articles' => [],
                'posts' => $this->projects->getPosts(3),
            ])
        );
    }
}
