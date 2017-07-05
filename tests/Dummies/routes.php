<?php
Route::group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function () {
    Route::resource('first', 'FirstDummiesController', ['except' => ['create', 'edit']]);
    Route::resource('second', 'SecondDummiesController', ['except' => ['create', 'edit']]);
});
