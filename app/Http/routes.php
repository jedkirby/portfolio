<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Main
\Route::get('/', 'HomeController@getHome');

// Static
\Route::get('about', 'StaticController@getAbout');
\Route::get('version', function(){ dd(client_version()); });

// Work
\Route::get('work', 'ProjectController@getProjects');
\Route::get('work/{slug}', 'ProjectController@getSingle');

// Blog
\Route::get('blog', 'BlogController@getArticles');
\Route::get('blog/{slug}', 'BlogController@getSingle');

// Contact
\Route::group(['middleware' => 'csrf'], function(){

    \Route::get('contact/{section?}', 'ContactController@getForm');
    \Route::post('contact', 'ContactController@postForm');

});

// Api(s)
\Route::group(['prefix' => 'api'], function(){

	// Interest
	\Route::post('interest/register', '\\App\\Http\\Api\\Interest@postRegister');

});

// Sitemap
\Route::get('sitemap.xml', 'StaticController@getSitemap');
