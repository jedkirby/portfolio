<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use SocialLinks\Page;

class ProjectController extends RootController {

	public static function projects($limit = false)
	{
		$projects = [
			'victoria-jeffs' => [
				'title'    => 'Victoria Jeffs',
				'sub'      => 'Estate Agent',
				'icon'     => 'fa fa-home',
				'date'     => Carbon::createFromDate(2015, 1, 5),
				'intro'    => view('pages.projects.projects.victoria-jeffs.intro'),
				'content'  => view('pages.projects.projects.victoria-jeffs.content'),
				'testi'    => false, //view('pages.projects.projects.victoria-jeffs.testimonial'),
				'link'     => 'http://victoriajeffs.co.uk',
				'expired'  => false,
				'keywords' => ['Victoria', 'Jeffs', 'Content Management System', 'CMS', 'Property', 'Estate Agent'],
				'hero'     => cached_asset('assets/img/projects/victoria-jeffs/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/victoria-jeffs/images/1.jpg'),
					cached_asset('assets/img/projects/victoria-jeffs/images/2.jpg'),
					cached_asset('assets/img/projects/victoria-jeffs/images/3.jpg'),
					cached_asset('assets/img/projects/victoria-jeffs/images/4.jpg')
				]
			],
			'php-warwickshire' => [
				'title'    => 'PHP Warwickshire',
				'sub'      => 'User Group',
				'icon'     => 'fa fa-code',
				'date'     => Carbon::createFromDate(2014, 10, 10),
				'intro'    => view('pages.projects.projects.php-warwickshire.intro'),
				'content'  => view('pages.projects.projects.php-warwickshire.content'),
				'testi'    => false,
				'link'     => 'http://phpwarks.co.uk',
				'expired'  => false,
				'keywords' => ['PHP', 'User Group', 'User', 'Group', 'Meetup', 'Rugby', 'Developers'],
				'hero'     => cached_asset('assets/img/projects/php-warwickshire/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/php-warwickshire/images/1.jpg'),
					cached_asset('assets/img/projects/php-warwickshire/images/2.jpg')
				]
			],
			'a-m-electrical' => [
				'title'    => 'A M Electrical',
				'sub'      => 'Electrical Contractors',
				'icon'     => 'fa fa-headphones',
				'date'     => Carbon::createFromDate(2014, 10, 11),
				'intro'    => view('pages.projects.projects.a-m-electrical.intro'),
				'content'  => view('pages.projects.projects.a-m-electrical.content'),
				'testi'    => false, //view('pages.projects.projects.a-m-electrical.testimonial'),
				'link'     => 'http://a-m-electrical.com',
				'expired'  => false,
				'keywords' => ['Aaron', 'Middleton', 'Electrical', 'Electrician'],
				'hero'     => cached_asset('assets/img/projects/a-m-electrical/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/a-m-electrical/images/1.jpg'),
					cached_asset('assets/img/projects/a-m-electrical/images/2.jpg'),
					cached_asset('assets/img/projects/a-m-electrical/images/3.jpg'),
					cached_asset('assets/img/projects/a-m-electrical/images/4.jpg'),
					cached_asset('assets/img/projects/a-m-electrical/images/5.jpg'),
					cached_asset('assets/img/projects/a-m-electrical/images/6.jpg')
				]
			],
			'admin-panel' => [
				'title'    => 'Admin Panel',
				'sub'      => 'Content Management',
				'icon'     => 'fa fa-cogs',
				'date'     => Carbon::createFromDate(2014, 11, 10),
				'intro'    => view('pages.projects.projects.admin-panel.intro'),
				'content'  => view('pages.projects.projects.admin-panel.content'),
				'link'     => false,
				'expired'  => false,
				'keywords' => ['CMS', 'Content Management System', 'Packages', 'Laravel'],
				'hero'     => cached_asset('assets/img/projects/admin-panel/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/admin-panel/images/1.jpg'),
					cached_asset('assets/img/projects/admin-panel/images/2.jpg'),
					cached_asset('assets/img/projects/admin-panel/images/3.jpg'),
					cached_asset('assets/img/projects/admin-panel/images/4.jpg'),
					cached_asset('assets/img/projects/admin-panel/images/5.jpg')
				]
			],
			'shrek-alarm' => [
				'title'    => 'Shrek Alarm',
				'sub'      => 'Mobile Application',
				'icon'     => 'fa fa-clock-o',
				'date'     => Carbon::createFromDate(2013, 8, 8),
				'intro'    => view('pages.projects.projects.shrek-alarm.intro'),
				'content'  => view('pages.projects.projects.shrek-alarm.content'),
				'link'     => false,
				'expired'  => 'This application and website is no longer available',
				'keywords' => ['Shrek', 'DreamWorks', 'Alarm Clock', 'Wake Up', 'iOS', 'Apple', 'iPhone', 'Android'],
				'hero'     => cached_asset('assets/img/projects/shrek-alarm/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/shrek-alarm/images/1.jpg'),
					cached_asset('assets/img/projects/shrek-alarm/images/2.jpg')
				]
			],
			'blitz-games' => [
				'title'    => 'Blitz Games',
				'sub'      => 'Responsive Design',
				'icon'     => 'fa fa-gamepad',
				'date'     => Carbon::createFromDate(2013, 6, 12),
				'intro'    => view('pages.projects.projects.blitz-games.intro'),
				'content'  => view('pages.projects.projects.blitz-games.content'),
				'link'     => 'http://blitzgames.com',
				'expired'  => false,
				'keywords' => ['Blitz', 'Games', 'Responsive', 'UX', 'SEO', 'CodeIgniter', 'Portfolio'],
				'hero'     => cached_asset('assets/img/projects/blitz-games/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/blitz-games/images/1.jpg'),
					cached_asset('assets/img/projects/blitz-games/images/2.jpg'),
					cached_asset('assets/img/projects/blitz-games/images/3.jpg'),
					cached_asset('assets/img/projects/blitz-games/images/4.jpg')
				]
			],
			'vuven' => [
				'title'    => 'Vuven',
				'sub'      => 'Rebrand',
				'icon'     => 'fa fa-database',
				'date'     => Carbon::createFromDate(2013, 4, 11),
				'intro'    => view('pages.projects.projects.vuven.intro'),
				'content'  => view('pages.projects.projects.vuven.content'),
				'link'     => 'http://vuven.com',
				'expired'  => false,
				'keywords' => ['Vuven', 'Website', 'Development', 'Design', 'Applications'],
				'hero'     => cached_asset('assets/img/projects/vuven/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/vuven/images/1.jpg'),
					cached_asset('assets/img/projects/vuven/images/2.jpg'),
					cached_asset('assets/img/projects/vuven/images/3.jpg')
				]
			],
			'blitz-tech' => [
				'title'    => 'BlitzTech',
				'sub'      => 'Responsive Design',
				'icon'     => 'fa fa-cog',
				'date'     => Carbon::createFromDate(2013, 2, 14),
				'intro'    => view('pages.projects.projects.blitz-tech.intro'),
				'content'  => view('pages.projects.projects.blitz-tech.content'),
				'link'     => false,
				'expired'  => 'This website is no longer available',
				'keywords' => ['Blitz', 'Tech', 'Technology', 'Software', 'Responsive', 'Design', 'Re-design', 'CSS3', 'HTML5'],
				'hero'     => cached_asset('assets/img/projects/blitz-tech/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/blitz-tech/images/1.jpg'),
					cached_asset('assets/img/projects/blitz-tech/images/2.jpg'),
					cached_asset('assets/img/projects/blitz-tech/images/3.jpg'),
					cached_asset('assets/img/projects/blitz-tech/images/4.jpg'),
					cached_asset('assets/img/projects/blitz-tech/images/5.jpg')
				]
			],
			'blitz-games-studios' => [
				'title'    => 'Blitz Games Studios',
				'sub'      => 'Redesigned Home Page',
				'icon'     => 'fa fa-trophy',
				'date'     => Carbon::createFromDate(2012, 12, 19),
				'intro'    => view('pages.projects.projects.blitz-games-studios.intro'),
				'content'  => view('pages.projects.projects.blitz-games-studios.content'),
				'link'     => 'http://blitzgamesstudios.com',
				'expired'  => false,
				'keywords' => ['Home Page', 'Re-design', 'Full Screen', 'Interactive', 'Dropdown Menu', 'Responsive'],
				'hero'     => cached_asset('assets/img/projects/blitz-games-studios/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/blitz-games-studios/images/1.jpg'),
					cached_asset('assets/img/projects/blitz-games-studios/images/2.jpg')
				]
			],
			'umberslade-adventure' => [
				'title'    => 'Umberslade Adventure',
				'sub'      => 'Outdoor Adventures',
				'icon'     => 'fa fa-paw',
				'date'     => Carbon::createFromDate(2012, 9, 1),
				'intro'    => view('pages.projects.projects.umberslade-adventure.intro'),
				'content'  => view('pages.projects.projects.umberslade-adventure.content'),
				'link'     => 'http://umbersladeadventure.com',
				'expired'  => false,
				'keywords' => ['Outdoor Adventures', 'Design', 'Build', 'HTML5', 'CSS3', 'Semantic Markup', 'Adventure', 'Playarea', 'Children', 'Days out'],
				'hero'     => cached_asset('assets/img/projects/umberslade-adventure/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/umberslade-adventure/images/1.jpg'),
					cached_asset('assets/img/projects/umberslade-adventure/images/2.jpg'),
					cached_asset('assets/img/projects/umberslade-adventure/images/3.jpg'),
					cached_asset('assets/img/projects/umberslade-adventure/images/4.jpg')
				]
			],
			'coca-cola' => [
				'title'    => 'Coca-Cola Promotion',
				'sub'      => 'User Interface',
				'icon'     => 'fa fa-hand-paper-o',
				'date'     => Carbon::createFromDate(2012, 1, 1),
				'intro'    => view('pages.projects.projects.coca-cola.intro'),
				'content'  => view('pages.projects.projects.coca-cola.content'),
				'link'     => false,
				'expired'  => 'This website is no longer available',
				'keywords' => ['Coca Cola', 'NFL', 'Super Bowl', '46', '2012', 'Promotion', 'Interactive', 'User Interface', 'Software'],
				'hero'     => cached_asset('assets/img/projects/coca-cola/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/coca-cola/images/1.jpg'),
					cached_asset('assets/img/projects/coca-cola/images/2.jpg'),
					cached_asset('assets/img/projects/coca-cola/images/3.jpg'),
					cached_asset('assets/img/projects/coca-cola/images/4.jpg')
				]
			],
			'well-forged-films' => [
				'title'    => 'Well Forged Films',
				'sub'      => 'Movie Portfolio',
				'icon'     => 'fa fa-video-camera',
				'date'     => Carbon::createFromDate(2011, 12, 21),
				'intro'    => view('pages.projects.projects.well-forged-films.intro'),
				'content'  => view('pages.projects.projects.well-forged-films.content'),
				'link'     => false,
				'expired'  => 'This website is no longer available',
				'keywords' => ['Film', 'Well Forged', 'Production Company'],
				'hero'     => cached_asset('assets/img/projects/well-forged-films/hero.jpg'),
				'images'   => [
					cached_asset('assets/img/projects/well-forged-films/images/1.jpg'),
					cached_asset('assets/img/projects/well-forged-films/images/2.jpg'),
					cached_asset('assets/img/projects/well-forged-films/images/3.jpg')
				]
			]
		];
		return ( $limit ? array_slice($projects, 0, $limit) : $projects );
	}

	public function getProjects()
	{

		$projects = static::projects();

		// Build a list of keywords based on project details
		$keywords = [];
		foreach($projects as $project){
			$keywords[] = array_get($project, 'title');
			$keywords[] = array_get($project, 'sub');
		}

		$this->setTitle('Work');
		$this->setDescription('Projects and personal work I have had envolvement with, including web design and development; application development and illustrations.');
		$this->setKeywords(implode(', ', array_unique(array_slice($keywords, 0, 15))));

		return view('pages.projects', compact('projects'));

	}

	public function getSingle($slug)
	{

		if( !($project = array_get(static::projects(), $slug, false)) ){
			abort(404);
		}

		// Create the social page information
		$social = new Page([
			'url'         => \URL::current(),
			'title'       => array_get($project, 'title'),
			'text'        => array_get($project, 'intro'),
			'image'       => array_get($project, 'images.0', ''),
			'twitterUser' => \Config::get('site.meta.twitter.handle')
		]);

		$this->setTitle(array_get($project, 'title'));
		$this->setDescription(strip_tags(array_get($project, 'intro')));
		$this->setKeywords(implode(', ', array_get($project, 'keywords', [])));

		return view('pages.projects.single', compact('project', 'social'));

	}

}
