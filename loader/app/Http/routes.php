<?php

Route::post('/warnings', 'TopController@hideWarnings');
Route::post('/imagePopup', 'ImageController@setInfoPopup');
Route::post('/set_route_parameters', 'TopController@setRouteParameters');

Route::get('/', function() {
    return redirect('/manage/login');
});

Route::group(['prefix' => 'manage'], function() {
    Route::get('login', 'AuthController@index');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('add_image/{it}/{return}/{field}/{pid?}/{sh?}', 'ImageController@index');
    Route::post('add_image/{pid?}', 'ImageController@add');
    Route::get('view_contact/{ed?}/{corporate?}', 'ContactController@view');
    Route::get('view_fcontact/{ed?}', 'ContactController@viewCorporateContact');
    Route::get('display_file/{file?}', 'FileController@display');
    Route::get('imageholder/{image}/{folder?}', 'ImageController@imageHolder');
    Route::get('add_contact/{ed?}', 'ContactController@index');
    Route::post('add_contact/{ed?}', 'ContactController@add');
    Route::post('search_contacts', 'ContactController@searchContact');
    Route::post('search_patients', 'PatientController@searchPatients');
    Route::get('add_task/{pid?}', 'TaskController@index');
    Route::post('add_task', 'TaskController@add');
    Route::get('view_sleeplab/{ed?}', 'SleepLabController@view');
    Route::get('add_sleeplab/{ed?}', 'SleepLabController@index');
    Route::post('add_sleeplab/{ed?}', 'SleepLabController@add');
    Route::get('custom/add', 'CustomController@index');
    Route::get('custom/{ed}/edit', 'CustomController@index');
    Route::post('add_custom/{ed?}', 'CustomController@add');
    Route::get('staff/{ed}/edit', 'StaffController@index');
    Route::get('staff/add', 'StaffController@index');
    Route::post('add_staff/{ed?}', 'StaffController@add');
    Route::get('chairs/{ed}/edit', 'ChairsController@index');
    Route::get('chairs/add', 'ChairsController@index');
    Route::post('add_chairs/{ed?}', 'ChairsController@add');

    Route::group(['middleware' => 'header'], function() {
        Route::get('index', 'IndexController@index');
        Route::get('add_patient/{pid?}', 'PatientController@index');
        Route::post('add_patient/{pid?}', 'PatientController@add');
        Route::get('duplicate_patient/{pid?}', 'PatientController@duplicate');
        Route::get('contact', 'ContactController@manage');
        Route::get('tasks', 'TaskController@manageTasks');
        Route::get('sleeplab', 'SleepLabController@manage');
        Route::get('fcontact', 'ContactController@manageCorporate');
        Route::get('custom', 'CustomController@manage');
        Route::get('staff', 'StaffController@manage');
        Route::get('chairs/{pid?}', 'ChairsController@manage');
    });
});

Route::group(['prefix' => 'manage', 'middleware'=>'auth'], function() {
    Route::get('admin/users', 'Admin\UserController@index');
    Route::get('admin/{id}/user', 'Admin\UserController@show');
    Route::get('admin/user/new', 'Admin\UserController@getNewUser');
    Route::post('admin/user/new', 'Admin\UserController@postNewUser');
    Route::post('admin/user/{id}/update', 'Admin\UserController@update');
    Route::get('admin/user/{id}/suspend', 'Admin\UserController@suspend');
    Route::get('admin/user/{id}/un-suspend', 'Admin\UserController@unSuspend');
    Route::get('admin/user/{id}/delete', 'Admin\UserController@delete');
    Route::get('admin/dashboard', 'Admin\DashboardController@index');
    Route::get('admin/accesscode', 'Admin\AccessCodeController@getIndex');
    Route::get('admin/accesscode/new', 'Admin\AccessCodeController@getAddAccessCode');
    Route::post('admin/accesscode/new', 'Admin\AccessCodeController@postAddAccessCode');
    Route::get('admin/accesscode/{id}/edit', ['as' => 'admin.accesscode.update', 'uses' => 'Admin\AccessCodeController@getUpdateAccessCode']);
    Route::post('admin/accesscode/{id}/update', 'Admin\AccessCodeController@postUpdateAccessCode');
    Route::get('admin/accesscode/{id}/delete', 'Admin\AccessCodeController@getDeleteAccessCode');

    Route::get('admin/backoffice/users', 'Admin\BackOfficeController@getIndex');
    Route::get('admin/backoffice/users/{id}/edit', 'Admin\BackOfficeController@getUpdateBackOfficeUser');
    Route::get('admin/backoffice/users/new', 'Admin\BackOfficeController@getAddBackOfficeUser');
    Route::post('admin/backoffice/users/new', 'Admin\BackOfficeController@postAddBackOfficeUser');
    Route::post('admin/backoffice/users/{id}/edit', 'Admin\BackOfficeController@postUpdateBackOfficeUser');
    Route::get('admin/backoffice/users/{id}/delete', 'Admin\BackOfficeController@deleteBackOfficeUser');

    Route::get('admin/plan', 'Admin\PlanController@getIndex');
    Route::get('admin/plan/new', 'Admin\PlanController@getAddNewPlan');
    Route::post('admin/plan/new', 'Admin\PlanController@postAddNewPlan');
    Route::get('admin/plan/{id}/edit', 'Admin\PlanController@getUpdatePlan');
    Route::post('admin/plan/{id}/edit', ['as' => 'plan.update', 'uses' => 'Admin\PlanController@postUpdatePlan']);
    Route::get('admin/plan/{id}/delete', 'Admin\PlanController@getDeletePlan');

    Route::resource('admin/companies', 'Admin\CompanyController');
});

Route::get('manage/admin/login', 'Admin\SessionController@index');
Route::post('manage/admin/login', 'Admin\SessionController@login');

Route::get("manage/admin/logout", 'Admin\SessionController@logout');
