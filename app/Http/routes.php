<?php

$router->post('/warnings', 'TopController@hideWarnings');
$router->post('/imagePopup', 'ImageController@setInfoPopup');
$router->post('/set_route_parameters', 'TopController@setRouteParameters');

$router->get('/', function() {
    return redirect('/manage/login');
});

$router->group(['prefix' => 'manage'], function() use ($router) {
    $router->get('login', 'AuthController@index');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');
    // $router->get('add_image/{pid?}', 'ImageController@index');
    $router->get('add_image/{it}/{return}/{field}/{pid?}/{sh?}', 'ImageController@index');
    $router->post('add_image/{pid?}', 'ImageController@add');
    $router->get('view_contact/{ed?}', 'ContactController@view');
    $router->get('display_file/{file?}', 'FileController@display');
    $router->get('imageholder/{image}/{folder?}', 'ImageController@imageHolder');
    $router->get('add_contact/{ed?}', 'ContactController@index');
    $router->post('add_contact/{ed?}', 'ContactController@add');
    $router->post('search_contacts', 'ContactController@searchContact');

    $router->group(['middleware' => 'header'], function() use ($router){
        $router->get('index', 'IndexController@index'); 
        $router->get('add_patient/{pid?}', 'PatientController@index');
        $router->post('add_patient/{pid?}', 'PatientController@add');
        $router->get('duplicate_patient/{pid?}', 'PatientController@duplicate');
        $router->get('contact', 'ContactController@manage');
    });
});

$router->group(['prefix' => 'manage', 'middleware'=>'auth'], function() use ($router) {
    $router->get('admin/users', 'Admin\UserController@index');
    $router->get('admin/{id}/user', 'Admin\UserController@show');
    $router->get('admin/user/new', 'Admin\UserController@getNewUser');
    $router->post('admin/user/new', 'Admin\UserController@postNewUser');
    $router->post('admin/user/{id}/update', 'Admin\UserController@update');
    $router->get('admin/user/{id}/suspend', 'Admin\UserController@suspend');
    $router->get('admin/user/{id}/un-suspend', 'Admin\UserController@unSuspend');
    $router->get('admin/user/{id}/delete', 'Admin\UserController@delete');
    $router->get('admin/dashboard', 'Admin\DashboardController@index');
    $router->get('admin/accesscode', 'Admin\AccessCodeController@getIndex');
    $router->get('admin/accesscode/new', 'Admin\AccessCodeController@getAddAccessCode');
    $router->post('admin/accesscode/new', 'Admin\AccessCodeController@postAddAccessCode');
    $router->get('admin/accesscode/{id}/edit', ['as' => 'admin.accesscode.update', 'uses' => 'Admin\AccessCodeController@getUpdateAccessCode']);
    $router->post('admin/accesscode/{id}/update', 'Admin\AccessCodeController@postUpdateAccessCode');
    $router->get('admin/accesscode/{id}/delete', 'Admin\AccessCodeController@getDeleteAccessCode');

    $router->get('admin/backoffice/users', 'Admin\BackOfficeController@getIndex');
    $router->get('admin/backoffice/users/{id}/edit', 'Admin\BackOfficeController@getUpdateBackOfficeUser');
    $router->get('admin/backoffice/users/new', 'Admin\BackOfficeController@getAddBackOfficeUser');
    $router->post('admin/backoffice/users/new', 'Admin\BackOfficeController@postAddBackOfficeUser');
    $router->post('admin/backoffice/users/{id}/edit', 'Admin\BackOfficeController@postUpdateBackOfficeUser');
    $router->get('admin/backoffice/users/{id}/delete', 'Admin\BackOfficeController@deleteBackOfficeUser');

    $router->get('admin/plan', 'Admin\PlanController@getIndex');
    $router->get('admin/plan/new', 'Admin\PlanController@getAddNewPlan');
    $router->post('admin/plan/new', 'Admin\PlanController@postAddNewPlan');
    $router->get('admin/plan/{id}/edit', 'Admin\PlanController@getUpdatePlan');
    $router->post('admin/plan/{id}/edit', ['as' => 'plan.update', 'uses' => 'Admin\PlanController@postUpdatePlan']);
    $router->get('admin/plan/{id}/delete', 'Admin\PlanController@getDeletePlan');

    $router->resource('admin/companies', 'Admin\CompanyController');
});

$router->get('manage/admin/login', 'Admin\SessionController@index');
$router->post('manage/admin/login', 'Admin\SessionController@login');

$router->get("manage/admin/logout", 'Admin\SessionController@logout');
