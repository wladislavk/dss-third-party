<?php
Route::group(['prefix' => 'api/v1', 'middleware' => ['jwt.auth.admin', 'jwt.auth.user']], function () {
    Route::resource('first', 'FirstDummiesController', ['except' => ['create', 'edit']]);
    Route::resource('second', 'SecondDummiesController', ['except' => ['create', 'edit']]);
});
Route::group(['prefix' => 'api/v1'], function () {
    Route::post('validation-exception', 'ValidationExceptionController@main');
});
