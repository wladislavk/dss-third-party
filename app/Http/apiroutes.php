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

        Route::get('eligiblelist/{page?}',['as' => 'eligible.enrollments.list',
            'uses' => 'Api\ApiEnrollmentsController@listEligibleEnrollments']);

        Route::get('list/{userid?}',['as' => 'enrollments.list',
            'uses' => 'Api\ApiEnrollmentsController@listEnrollments']);

        Route::get('apikey/{userid}',['as' => 'enrollments.apikey',
            'uses' => 'Api\ApiEnrollmentsController@getDentalUserCompanyApiKey']);

        Route::get('type/{id}',['as' => 'enrollments.type',
            'uses' => 'Api\ApiEnrollmentsController@getEnrollmentTransactionType']);

        Route::get('syncpayers',['as' => 'enrollments.syncpayers',
            'uses' => 'Api\ApiEnrollmentsController@syncEnrollmentPayers']);

    });

    Route::resource('allergen', 'Api\ApiAllergenController');
});