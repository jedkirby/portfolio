<?php

namespace App\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Project\Repository\PostRepository;
use App\Domain\Social\Page;
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
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var Page
     */
    private $page;

    /**
     * @param Domain $domain
     * @param PostRepository $postRepository
     * @param Page $page
     */
    public function __construct(
        Domain $domain,
        PostRepository $postRepository,
        Page $page
    ) {
        $this->domain = $domain;
        $this->postRepository = $postRepository;
        $this->page = $page;
    }

    /**
     * @return View
     */
    public function all()
    {
        $projects = $this->postRepository->getAll();

        $keywords = [];
        foreach ($projects as $project) {
            $keywords[] = $project->getTitle();
            $keywords[] = $project->getSubTitle();
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
            $this->getViewParams(compact('projects'))
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
            $project = $this->postRepository->getById($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        $this->domain->setTitle($project->getTitle());
        $this->domain->setDescription($project->getIntroductionForMeta());
        $this->domain->setKeywords($project->getKeywords());

        $this->page->setUrl($project->getUrl());
        $this->page->setTitle($project->getTitle());
        $this->page->setText($project->getIntroductionForMeta());

        if ($images = $project->getImages()) {
            $this->page->setImage(reset($images));
        }

        return view(
            'pages.projects.single',
            $this->getViewParams([
                'project' => $project,
                'page' => $this->page,
            ])
        );
    }
}
