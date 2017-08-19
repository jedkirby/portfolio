<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Work\Repository\WorkRepository;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * @var WorkRepository
     */
    private $workRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @param WorkRepository $workRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        WorkRepository $workRepository,
        ArticleRepository $articleRepository
    ) {
        $this->workRepository = $workRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        $routes = [
            route('home'),
            route('about'),
            route('contact'),
        ];

        // $routes[] = route('work');
        // foreach ($this->workRepository->getAll() as $id => $post) {
            // $routes[] = route('work', $id);
        // }

        $routes[] = route('articles');
        foreach ($this->articleRepository->getAll() as $id => $article) {
            $routes[] = route('article', $id);
        }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
