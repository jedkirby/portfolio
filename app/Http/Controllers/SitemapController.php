<?php

namespace App\Http\Controllers;

use App\Domain\Project\ProjectManager as Projects;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * @var Projects
     */
    private $projects;

    /**
     * @param Projects $projects
     */
    public function __construct(
        Projects $projects
    ) {
        $this->projects = $projects;
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
        foreach ($this->projects->getPosts() as $id => $post) {
            $routes[] = 'work/' . $id;
        }

        // $routes[] = 'blog';
        // foreach (Blog::articles() as $url => $article) {
            // $routes[] = 'blog/' . $url;
        // }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
