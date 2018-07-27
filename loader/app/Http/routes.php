<?php

Route::get('/', function() {
    return redirect('/manage/login');
});

Route::group(['prefix' => 'manage', 'middleware'=>'auth'], function() {
    Route::get('admin/dashboard', 'Admin\DashboardController@index');
});
