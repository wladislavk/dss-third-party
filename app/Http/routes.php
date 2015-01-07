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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/manage/login', 'Auth\AuthController@index');
Route::post('/manage/login', 'Auth\AuthController@login');

Route::get('/manage/index', 'IndexController@index');

$router->group([],function() use ($router) {

    $router->get('/admin/dashboard','Admin\DashboardController@index');
});

