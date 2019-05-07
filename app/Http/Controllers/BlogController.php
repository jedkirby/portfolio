<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Common\KeywordGenerator;
use App\Domain\Domain;
use App\Domain\Social\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends AbstractController
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
     * @var Page
     */
    private $page;

    /**
     * @param Domain $domain
     * @param ArticleRepository $articleRepository
     * @param Page $page
     */
    public function __construct(
        Domain $domain,
        ArticleRepository $articleRepository,
        Page $page
    ) {
        $this->domain = $domain;
        $this->articleRepository = $articleRepository;
        $this->page = $page;
    }

    /**
     * @return Illuminate\View\View
     */
    public function all()
    {
        $articles = $this->articleRepository->getAll();

        $keywords = [];
        foreach ($articles as $article) {
            $keywords = array_merge($keywords, $article->getKeywords());
        }

        $generator = new KeywordGenerator($keywords);

        $this->domain->setTitle('Blog');
        $this->domain->setDescription('From time to time I create articles. These could range from server configuration guides to life experiences. Feel free to get to know me more by reading a few of my articles.');
        $this->domain->setKeywords($generator->run());

        return view(
            'pages.blog',
            $this->getViewParams(compact('articles'))
        );
    }

    /**
     * @param string $id
     *
     * @return Illuminate\View\View
     */
    public function single($id)
    {
        try {
            $article = $this->articleRepository->getById($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        $this->domain->setTitle($article->getTitle());
        $this->domain->setDescription($article->getSnippet());
        $this->domain->setKeywords($article->getKeywordsForMeta());

        $this->page->setUrl($article->getUrl());
        $this->page->setTitle($article->getTitle());
        $this->page->setText($article->getSnippet());
        $this->page->setImage($article->getImage());

        return view(
            'pages.blog.single',
            $this->getViewParams([
                'article' => $article,
                'page' => $this->page,
            ])
        );
    }
}
