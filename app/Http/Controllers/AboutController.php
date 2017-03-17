<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Domain;
use App\Domain\Project\Repository\PostRepository;
use App\Domain\Service\Instagram\InstagramManager;
use Carbon\Carbon;

class AboutController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var InstagramManager
     */
    private $instagramManager;

    /**
     * @param Domain $domain
     * @param ArticleRepository $articleRepository
     * @param PostRepository $postRepository
     * @param InstagramManager $instagramManager
     */
    public function __construct(
        Domain $domain,
        ArticleRepository $articleRepository,
        PostRepository $postRepository,
        InstagramManager $instagramManager
    ) {
        $this->domain = $domain;
        $this->articleRepository = $articleRepository;
        $this->postRepository = $postRepository;
        $this->instagramManager = $instagramManager;
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
                'instagram' => $this->instagramManager->getPosts(),
                'counts' => [
                    'tea' => $startedWorking->diffInDays(),
                    'food' => $startedWorking->diffInWeeks(),
                    'projects' => $this->postRepository->getCount(),
                    'articles' => $this->articleRepository->getCount(),
                ],
            ])
        );
    }
}
