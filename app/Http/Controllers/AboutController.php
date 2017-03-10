<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Http\Controllers\BlogController as Blog;
use App\Http\Controllers\ProjectController as Project;
use App\Services\Instagram\InstagramManager as Instagram;
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
     * @param Domain $domain
     * @param Instagram $instagram
     */
    public function __construct(
        Domain $domain,
        Instagram $instagram
    ) {
        $this->domain = $domain;
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

        $totalProjects = count(Project::projects());
        $totalArticles = count(Blog::articles());

        return view(
            'pages.about',
            $this->getViewParams([
                'instagram' => $this->instagram->getPosts(),
                'counts' => [
                    'tea' => $startedWorking->diffInDays(),
                    'food' => $startedWorking->diffInWeeks(),
                    'projects' => $totalProjects,
                    'articles' => $totalArticles,
                ],
            ])
        );
    }
}
