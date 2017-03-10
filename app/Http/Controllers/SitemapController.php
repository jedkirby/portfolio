<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BlogController as Blog;
use App\Http\Controllers\ProjectController as Project;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
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
        foreach (Project::projects() as $url => $project) {
            $routes[] = 'work/' . $url;
        }

        $routes[] = 'blog';
        foreach (Blog::articles() as $url => $article) {
            $routes[] = 'blog/' . $url;
        }

        return response()
            ->view('pages.sitemap.master', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}
