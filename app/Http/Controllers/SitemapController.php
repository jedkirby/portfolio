<?php

namespace App\Http\Controllers;

use App\Domain\Blog\BlogManager;
use App\Domain\Project\ProjectManager;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * @var ProjectManager
     */
    private $project;

    /**
     * @var BlogManager
     */
    private $blog;

    /**
     * @param ProjectManager $project
     * @param BlogManager $blog
     */
    public function __construct(
        ProjectManager $project,
        BlogManager $blog
    ) {
        $this->project = $project;
        $this->blog = $blog;
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

        $routes[] = route('projects');
        foreach ($this->project->getAll() as $id => $post) {
            $routes[] = route('project', $id);
        }

        $routes[] = route('articles');
        foreach ($this->blog->getAll() as $id => $article) {
            $routes[] = route('article', $id);
        }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
