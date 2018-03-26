<?php
Route::group(['prefix' => 'api/v1', 'middleware' => ['jwt.auth.admin', 'jwt.auth.user']], function () {
    Route::resource('first', 'FirstDummiesController', ['except' => ['create', 'edit']]);
    Route::resource('second', 'SecondDummiesController', ['except' => ['create', 'edit']]);
});
