<?php

// Route::get('/pid/{pid}', array('middleware' => 'header', 'uses' => 'WelcomeController@index'));

$router->group(['prefix' => 'manage'], function() use ($router) {
	$router->get('login', 'AuthController@index');
	$router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');

	$router->group(['middleware' => 'header'], function() use ($router){
        $router->get('index', 'IndexController@index');  
    });
});

$router->group([],function() use ($router) {
    $router->get('admin/manage/vob','Admin\VobController@index');
    $router->get('manage/admin/users','Admin\UserController@index');
    $router->get('manage/admin/{id}/user','Admin\UserController@show');
    $router->post('manage/admin/user/{id}/update','Admin\UserController@update');
    $router->get('/manage/admin/user/{id}/suspend','Admin\UserController@suspend');
    $router->get('manage/admin/user/{id}/un-suspend','Admin\UserController@unSuspend');
    $router->get('manage/admin/user/{id}/delete','Admin\UserController@delete');
    $router->get('manage/admin/dashboard','Admin\DashboardController@index');
});
$router->get('manage/admin/login','Admin\AuthController@index');
$router->post('manage/admin/login','Admin\AuthController@login');

$router->get("manage/admin/logout",'Admin\AuthController@logout');

