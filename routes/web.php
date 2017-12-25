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

Route::get('/', 'HomeController')->name('home');
Route::get('about', 'AboutController')->name('about');
Route::get('version', 'VersionController')->name('version');
Route::get('work', 'ProjectController@all')->name('projects');
Route::get('work/{slug}', 'ProjectController@single')->name('project');
Route::get('blog', 'BlogController@all')->name('articles');
Route::get('blog/{slug}', 'BlogController@single')->name('article');
Route::get('contact', 'ContactController@get')->name('contact');
Route::get('pings', 'PingController');
Route::get('sitemap.xml', 'SitemapController')->name('sitemap');

Route::post('contact', 'ContactController@post');
Route::post('api/interest/register', 'InterestController')->name('api.interest');

