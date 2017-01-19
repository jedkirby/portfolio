<?php

namespace App\Http\Controllers;

use App\Services\Twitter\TweetManager;

class HomeController extends RootController
{
    public function getHome()
    {
        $this->setDescription('Website and application developer based in Stratford Upon Avon, UK. An avid blogger of anything related to social media, business, entertainment or technology. Primarily covering Warwickshire, but expanding to the rest of the world to provide a stress free and professional service. Available for hire.');

        return view('pages.home', [
            'tweet' => TweetManager::getTweet(),
            'articles' => BlogController::articles(2),
            'projects' => ProjectController::projects(3),
        ]);
    }
}
