<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => '', 'after' => 'allowOrigin'], function ()
{
    Route::resource('memo','Api\ApiAdminMemoController');
    Route::group(['prefix' => 'enrollment'], function(){
        Route::get('payers',['as' => 'payers.list', 'uses' => 'Api\ApiEnrollmentsController@payersList']);
        Route::post('create',['as' => 'create.enrollment', 'uses' => 'Api\ApiEnrollmentsController@createEnrollment']);
        Route::put('update',['as' => 'update.enrollment', 'uses' => 'Api\ApiEnrollmentsController@updateEnrollment']);
        Route::get('show',['as' => 'show.enrollment', 'uses' => 'Api\ApiEnrollmentsController@showEnrollment']);
        Route::delete('delete',['as' => 'delete.enrollment', 'uses' => 'Api\ApiEnrollmentsController@destroyEnrollment']);
    });
});