<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => '', 'after' => 'allowOrigin'], function ()
{
    Route::resource('memo','Api\ApiAdminMemoController');

    Route::group(['prefix' => 'enrollments'], function(){

        Route::post('create',['as' => 'enrollments.create',
                            'uses' => 'Api\ApiEnrollmentsController@createEnrollment']);

        Route::post('update/{enrollmentid}',['as' => 'enrollments.update',
                            'uses' => 'Api\ApiEnrollmentsController@updateEnrollment']);

        Route::get('retrieve/{enrollmentid}',['as' => 'enrollments.retrieve',
                            'uses' => 'Api\ApiEnrollmentsController@retrieveEnrollment']);

        Route::delete('delete',['as' => 'enrollments.delete',
                            'uses' => 'Api\ApiEnrollmentsController@destroyEnrollment']);

        Route::get('list/{page?}',['as' => 'enrollments.list',
            'uses' => 'Api\ApiEnrollmentsController@listEnrollments']);

    });
});