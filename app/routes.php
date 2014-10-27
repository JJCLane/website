<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Read Article
|--------------------------------------------------------------------------
*/

Route::get('article/{slug}', 'ArticleController@getArticle');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
/*Route::get('/', function(){
	return "yes";
});*/
Route::controller('/', 'HomeController');