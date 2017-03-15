<?php

namespace App\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Project\ProjectManager;
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
     * @var ProjectManager
     */
    private $project;

    /**
     * @param Domain $domain
     * @param ProjectManager $project
     */
    public function __construct(
        Domain $domain,
        ProjectManager $project
    ) {
        $this->domain = $domain;
        $this->project = $project;
    }

    /**
     * @return View
     */
    public function all()
    {
        $posts = $this->project->getAll();

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
            $post = $this->project->getById($id);
        } catch (EntityNotFoundException $e) {
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
