<?php

namespace App\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Domain;
use App\Domain\Project\ProjectManager;
use App\Domain\Service\Twitter\TweetManager;

class HomeController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var BlogManager
     */
    private $blog;

    /**
     * @var ProjectManager
     */
    private $project;

    /**
     * @var TweetManager
     */
    private $twitter;

    /**
     * @param Domain $domain
     * @param BlogManager $blog
     * @param ProjectManager $project
     * @param TweetManager $twitter
     */
    public function __construct(
        Domain $domain,
        BlogManager $blog,
        ProjectManager $project,
        TweetManager $twitter
    ) {
        $this->domain = $domain;
        $this->blog = $blog;
        $this->project = $project;
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
                'articles' => $this->blog->getLimit(3),
                'projects' => $this->project->getLimit(3),
                'tweet' => $this->twitter->getTweet(),
            ])
        );
    }
}
