<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Integrations\Meetup;
use App\Integrations\Twitter;

class HomeController extends RootController {

	public function getHome()
	{

		$this->setDescription('Website and application developer based in Leamington Spa, UK. An avid blogger of anything related to social media, business, entertainment or technology. Primarily covering Warwickshire, but expanding to the rest of the world to provide a stress free and professional service. Available for hire.');

		return view('pages.home', [
			'tweet'    => Twitter::getLatest(),
			'meetups'  => Meetup::getEvents(),
			'articles' => BlogController::articles(2),
			'projects' => ProjectController::projects(3)
		]);

	}

}
