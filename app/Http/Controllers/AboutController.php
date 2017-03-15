<?php

namespace App\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Domain;
use App\Domain\Project\ProjectManager;
use App\Domain\Service\Instagram\InstagramManager;
use Carbon\Carbon;

class AboutController extends AbstractController
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
     * @var InstagramManager
     */
    private $instagram;

    /**
     * @param Domain $domain
     * @param BlogManager $blog
     * @param ProjectManager $project
     * @param InstagramManager $instagram
     */
    public function __construct(
        Domain $domain,
        BlogManager $blog,
        ProjectManager $project,
        InstagramManager $instagram
    ) {
        $this->domain = $domain;
        $this->blog = $blog;
        $this->project = $project;
        $this->instagram = $instagram;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        $this->domain->setTitle('About');
        $this->domain->setDescription("I work in both LEMP and LAMP environments and pride myself on my ability to use multiple frameworks, such as; Laravel, Symfony, CodeIgniter and FuelPHP, aside from those I've got great experience in hand coding and bug fixing in native PHP.");

        $startedWorking = Carbon::createFromDate(2011, 4);

        return view(
            'pages.about',
            $this->getViewParams([
                'instagram' => $this->instagram->getPosts(),
                'counts' => [
                    'tea' => $startedWorking->diffInDays(),
                    'food' => $startedWorking->diffInWeeks(),
                    'projects' => $this->project->getCount(),
                    'articles' => $this->blog->getCount(),
                ],
            ])
        );
    }
}
