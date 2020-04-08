<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Project\Repository\PostRepository;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @param PostRepository $postRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        PostRepository $postRepository,
        ArticleRepository $articleRepository
    ) {
        $this->postRepository = $postRepository;
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
            route('policy.privacy'),
            route('policy.cookie'),
        ];

        $routes[] = route('projects');
        foreach ($this->postRepository->getAll() as $id => $post) {
            $routes[] = route('project', $id);
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
