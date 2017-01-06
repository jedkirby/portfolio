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

// Main
Route::get('/', 'HomeController@getHome');

// Static
Route::get('about', 'StaticController@getAbout');
Route::get('version', function(){ dd(client_version()); });

// Work
Route::get('work', 'ProjectController@getProjects');
Route::get('work/{slug}', 'ProjectController@getSingle');

// Blog
Route::get('blog', 'BlogController@getArticles');
Route::get('blog/{slug}', 'BlogController@getSingle');

// Contact
Route::group(['middleware' => 'csrf'], function(){

    Route::get('contact/{section?}', 'ContactController@getForm');
    Route::post('contact', 'ContactController@postForm');

});

// Api(s)
Route::group(['prefix' => 'api'], function(){

    // Interest
    Route::post('interest/register', '\\App\\Http\\Api\\Interest@postRegister');

});

// Sitemap
Route::get('sitemap.xml', 'StaticController@getSitemap');
