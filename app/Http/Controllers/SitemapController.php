<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Study\Repository\StudyRepository;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * @var StudyRepository
     */
    private $studyRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @param StudyRepository $studyRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        StudyRepository $studyRepository,
        ArticleRepository $articleRepository
    ) {
        $this->studyRepository = $studyRepository;
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

        $routes[] = route('studies');
        foreach ($this->studyRepository->getAll() as $id => $post) {
            $routes[] = route('study', $id);
        }

        $routes[] = route('articles');
        foreach ($this->articleRepository->getAll() as $id => $article) {
            $routes[] = route('article', $id);
        }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
