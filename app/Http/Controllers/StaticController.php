<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BlogController as Blogs;
use App\Http\Controllers\ProjectController as Projects;
use App\Integrations\Instagram;
use Carbon\Carbon;

class StaticController extends RootController
{
    public function getAbout()
    {
        $this->setTitle('About');
        $this->setDescription('I work in both LEMP and LAMP environments and pride myself on my ability to use multiple frameworks, such as; Laravel, Symfony, CodeIgniter and FuelPHP, aside from those I\'ve got great experience in hand coding and bug fixing in native PHP.');

        $startedWorking = Carbon::createFromDate(2011, 4);
        $totalProjects = count(Projects::projects());
        $totalArticles = count(Blogs::articles());

        return view('pages.about', [
            'instagram' => Instagram::getPosts(),
            'counts' => [
                'tea' => $startedWorking->diffInDays(),
                'food' => $startedWorking->diffInWeeks(),
                'projects' => $totalProjects,
                'articles' => $totalArticles,
            ],
        ]);
    }

    public function getSitemap()
    {
        // Static routes
        $routes = [
            '/',
            'about',
            'contact',
        ];

        // Work
        $routes[] = 'work';
        foreach (Projects::projects() as $url => $project) {
            $routes[] = 'work/' . $url;
        }

        // Blog
        $routes[] = 'blog';
        foreach (Blogs::articles() as $url => $article) {
            $routes[] = 'blog/' . $url;
        }

        $view = \View::make('pages.sitemap.master')->with('routes', $routes);

        return \Response::make($view)->header('Content-Type', 'text/xml');
    }
}
