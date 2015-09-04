<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => '', 'after' => 'allowOrigin'], function ()
{
    Route::resource('memo','Api\ApiAdminMemoController');
    Route::resource('enrollment','Api\ApiEnrollmentsController');
    Route::group(['prefix' => 'enrollment'], function(){
        Route::get('payers',['as' => 'payers.list', 'uses' => 'Api\ApiEnrollmentsController@payersList']);
    });
});