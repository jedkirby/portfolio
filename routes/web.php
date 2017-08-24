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
Route::get('case-study', 'CaseStudyController@all');
Route::get('case-study/{slug}', 'CaseStudyController@single')->name('case-study');
Route::get('blog', 'BlogController@all')->name('articles');
Route::get('blog/{slug}', 'BlogController@single')->name('article');
Route::get('contact', 'ContactController@get')->name('contact');
Route::get('sitemap.xml', 'SitemapController')->name('sitemap');

Route::post('contact', 'ContactController@post');
