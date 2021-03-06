<?php

namespace App\Http\Controllers;

use App\Domain\Blog\Repository\ArticleRepository;
use App\Domain\Domain;
use App\Domain\Project\Repository\PostRepository;
use App\Domain\Service\Twitter\TweetManager;

class HomeController extends AbstractController
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
     * @var TweetManager
     */
    private $tweetManager;

    /**
     * @param Domain $domain
     * @param ArticleRepository $articleRepository
     * @param PostRepository $postRepository
     * @param TweetManager $tweetManager
     */
    public function __construct(
        Domain $domain,
        ArticleRepository $articleRepository,
        PostRepository $postRepository,
        TweetManager $tweetManager
    ) {
        $this->domain = $domain;
        $this->articleRepository = $articleRepository;
        $this->postRepository = $postRepository;
        $this->tweetManager = $tweetManager;
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
                'articles' => $this->articleRepository->getLimit(2),
                'projects' => $this->postRepository->getLimit(3),
                'tweet' => $this->tweetManager->getTweet(),
            ])
        );
    }
}
