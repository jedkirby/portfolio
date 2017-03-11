<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use App\Domain\Project\Exception\PostNotFoundException;
use App\Domain\Project\ProjectManager as Projects;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends AbstractController
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
     * @var Projects
     */
    private $projects;

    /**
     * @param Domain $domain
     * @param Projects $projects
     */
    public function __construct(
        Domain $domain,
        Projects $projects
    ) {
        $this->domain = $domain;
        $this->projects = $projects;
    }

    /**
     * @return View
     */
    public function all()
    {
        $posts = $this->projects->getPosts();

        $keywords = [];
        foreach ($posts as $post) {
            $keywords[] = $post->getTitle();
            $keywords[] = $post->getSubTitle();
        }

        $this->domain->setTitle('Work');
        $this->domain->setDescription('Projects and personal work I have had envolvement with, including web design and development; application development and illustrations.');
        $this->domain->setKeywords(
            array_unique(
                array_slice($keywords, 0, static::KEYWORD_LIMIT) // NB: We only want a maximum of 15 keywords.
            )
        );

        return view(
            'pages.projects',
            $this->getViewParams(compact('posts'))
        );
    }

    /**
     * @param string $id
     *
     * @return View
     */
    public function single($id)
    {
        try {
            $post = $this->projects->getPost($id);
        } catch (PostNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        $this->domain->setTitle($post->getTitle());
        $this->domain->setDescription(strip_tags($post->getIntroduction()));
        $this->domain->setKeywords($post->getKeywords());

        /*
        $social = new \SocialLinks\Page([
            'url' => \URL::current(),
            'title' => array_get($project, 'title'),
            'text' => array_get($project, 'intro'),
            'image' => array_get($project, 'images.0', ''),
            'twitterUser' => \Config::get('site.meta.twitter.handle'),
        ]);
        */

        return view(
            'pages.projects.single',
            $this->getViewParams(compact('post'))
        );
    }
}
