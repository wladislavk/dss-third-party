<?php

// Route::get('/pid/{pid}', array('middleware' => 'header', 'uses' => 'WelcomeController@index'));

$router->post('/warnings', 'TopController@hideWarnings');
$router->get('/', function() {
    return redirect('/manage/login');
});

$router->group(['prefix' => 'manage'], function() use ($router) {
	$router->get('login', 'AuthController@index');
	$router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');

	$router->group(['middleware' => 'header'], function() use ($router){
        $router->get('index', 'IndexController@index'); 
        $router->get('add_patient/{pid?}', 'PatientController@index');
        $router->post('add_patient/{pid?}', 'PatientController@add');
        $router->get('duplicate_patient/{pid?}', 'PatientController@duplicate');
    });
});

$router->group(['prefix' => 'manage'],function() use ($router) {
    $router->get('admin/users','Admin\UserController@index');
    $router->get('admin/{id}/user','Admin\UserController@show');
    $router->get('admin/user/new','Admin\UserController@getNewUser');
    $router->post('admin/user/new','Admin\UserController@postNewUser');
    $router->post('admin/user/{id}/update','Admin\UserController@update');
    $router->get('admin/user/{id}/suspend','Admin\UserController@suspend');
    $router->get('admin/user/{id}/un-suspend','Admin\UserController@unSuspend');
    $router->get('admin/user/{id}/delete','Admin\UserController@delete');
    $router->get('admin/dashboard','Admin\DashboardController@index');
    $router->get('admin/accesscode','Admin\AccessCodeController@getIndex');
    $router->get('admin/accesscode/new','Admin\AccessCodeController@getAddAccessCode');
    $router->post('admin/accesscode/new','Admin\AccessCodeController@postAddAccessCode');
    $router->get('admin/accesscode/{id}/edit',['as'=>'admin.accesscode.update','uses'=>'Admin\AccessCodeController@getUpdateAccessCode']);
    $router->post('admin/accesscode/{id}/update','Admin\AccessCodeController@postUpdateAccessCode');
    $router->get('admin/accesscode/{id}/delete','Admin\AccessCodeController@getDeleteAccessCode');

//    /manage/admin/accesscode/{{$code->id}}/delete
    $router->get('admin/backoffice/users','Admin\BackOfficeController@getIndex');

});
$router->get('manage/admin/login','Admin\SessionController@index');
$router->post('manage/admin/login','Admin\SessionController@login');

$router->get("manage/admin/logout",'Admin\SessionController@logout');

