<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\ProjectManager as Projects;
use App\Domain\Service\Instagram\InstagramManager as Instagram;
use Carbon\Carbon;

class AboutController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var Instagram
     */
    private $instagram;

    /**
     * @var Projects
     */
    private $projects;

    /**
     * @param Domain $domain
     * @param Instagram $instagram
     * @param Projects $projects
     */
    public function __construct(
        Domain $domain,
        Instagram $instagram,
        Projects $projects
    ) {
        $this->domain = $domain;
        $this->instagram = $instagram;
        $this->projects = $projects;
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
                    'projects' => $this->projects->getPostsCount(),
                    'articles' => 0,
                ],
            ])
        );
    }
}
