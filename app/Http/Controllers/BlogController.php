<?php

namespace App\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends AbstractController
{
    /**
     * @var int
     */
    const KEYWORD_LIMIT = 15;

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var BlogManager
     */
    private $manager;

    /**
     * @param Domain $domain
     * @param BlogManager $manager
     */
    public function __construct(
        Domain $domain,
        BlogManager $manager
    ) {
        $this->domain = $domain;
        $this->manager = $manager;
    }

    /**
     * @return Illuminate\View\View
     */
    public function all()
    {
        $posts = $this->manager->getPosts();

        $keywords = [];
        foreach ($posts as $post) {
            $keywords[] = $post->getKeywords();
        }

        $this->domain->setTitle('Blog');
        $this->domain->setDescription('From time to time I create articles. These could range from server configuration guides to life experiences. Feel free to get to know me more by reading a few of my articles.');
        $this->domain->setKeywords(
            array_unique(
                array_slice($keywords, 0, static::KEYWORD_LIMIT) // NB: We only want a maximum of 15 keywords.
            )
        );

        return view(
            'pages.blog',
            $this->getViewParams(compact('posts'))
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
            $post = $this->manager->getPost($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        $this->domain->setTitle($post->getTitle());
        $this->domain->setDescription($post->getSnippet());
        $this->domain->setKeywords($post->getKeywords());

        /*
        $social = new Page([
            'url' => \URL::current(),
            'title' => array_get($article, 'title'),
            'text' => array_get($article, 'snippet'),
            'image' => array_get($article, 'image', ''),
            'twitterUser' => \Config::get('site.meta.twitter.handle'),
        ]);
        */

        return view(
            'pages.blog.single',
            $this->getViewParams(compact('post'))
        );
    }
}
