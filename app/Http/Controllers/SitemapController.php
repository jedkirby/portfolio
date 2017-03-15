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
            '/',
            'about',
            'contact',
        ];

        $routes[] = 'work';
        foreach ($this->project->getAll() as $id => $post) {
            $routes[] = 'work/' . $id;
        }

        $routes[] = 'blog';
        foreach ($this->blog->getAll() as $id => $article) {
            $routes[] = 'blog/' . $id;
        }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
