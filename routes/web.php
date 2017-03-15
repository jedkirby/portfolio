<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController');

Route::get('about', 'AboutController');
Route::get('version', function () {
    dd(client_version());
});

Route::get('work', 'ProjectController@all');
Route::get('work/{slug}', 'ProjectController@single');

Route::get('blog', 'BlogController@all');
Route::get('blog/{slug}', 'BlogController@single');

Route::get('contact', 'ContactController@get');
Route::post('contact', 'ContactController@post');

Route::group(['prefix' => 'api'], function () {
    Route::post('interest/register', 'InterestController');
});

Route::get('sitemap.xml', 'SitemapController');
