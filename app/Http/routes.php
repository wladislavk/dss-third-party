<?php


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/manage/login', 'Auth\AuthController@index');
Route::post('/manage/login', 'Auth\AuthController@login');

Route::get('/manage/index', 'IndexController@index');

$router->group([],function() use ($router) {
    $router->get('admin/manage/vob','Admin\VobController@index');
    $router->get('manage/admin/users','Admin\UserController@index');
    $router->get('manage/admin/{id}/user','Admin\UserController@show');
    $router->post('manage/admin/user/{id}/update','Admin\UserController@update');
    $router->get('/manage/admin/user/{id}/suspend','Admin\UserController@suspend');
    $router->get('manage/admin/user/{id}/un-suspend','Admin\UserController@unSuspend');
    $router->get('manage/admin/user/{id}/delete','Admin\UserController@delete');
    $router->get('manage/admin/login','Admin\AuthController@index');
    $router->post('manage/admin/login','Admin\AuthController@login');
});

