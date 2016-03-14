<?php

/*
|--------------------------------------------------------------------------
| Authenticate user and get a token for subsequent requests
|--------------------------------------------------------------------------
*/
Route::post('auth', function () {
    if (!$token = JWTAuth::attempt(Request::all())) {
        return Response::json(['status' => 'Invalid credentials'], 422);
    }

    return ['status' => 'Authenticated', 'token' => $token];
});


/*
|--------------------------------------------------------------------------
| Eligible webhooks
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'webhooks'], function () {
    Route::any('enrollment', ['as' => 'webhooks.enrollment', 'uses' => 'Eligible\WebhooksController@enrollment']);
    Route::any('claims', ['as' => 'webhooks.claims', 'uses' => 'Eligible\WebhooksController@claims']);
    Route::any('payment', ['as' => 'webhooks.payment', 'uses' => 'Eligible\WebhooksController@payment']);
    Route::any('payers', ['as' => 'webhooks.payers', 'uses' => 'Eligible\WebhooksController@payers']);
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'middleware' => 'jwt.auth'], function () {

    Route::resource('qualifiers', 'QualifiersController', ['except' => ['create', 'edit']]);

    Route::resource('claim-note-attachments', 'ClaimNoteAttachmentsController', ['except' => ['create', 'edit']]);
    Route::resource('complaints', 'ComplaintsController', ['except' => ['create', 'edit']]);
    Route::resource('custom-texts', 'CustomTextsController', ['except' => ['create', 'edit']]);
    Route::resource('contact-types', 'ContactTypesController', ['except' => ['create', 'edit']]);
    Route::resource('contacts', 'ContactsController', ['except' => ['create', 'edit']]);
    Route::resource('devices', 'DevicesController', ['except' => ['create', 'edit']]);

    Route::get('payers/{payer_id}/required-fields', 'PayersController@requiredFields');
    // temporary, alias for the above to satisfy current JS
    Route::get('enrollments/requiredfields/{payer_id}', 'PayersController@requiredFields');
    Route::resource('payers', 'PayersController', ['except' => ['create', 'edit']]);
    Route::resource('appt-types', 'AppointmentTypesController', ['except' => ['create', 'edit']]);
    Route::resource('access-codes', 'AccessCodesController', ['except' => ['create', 'edit']]);
    Route::resource('calendars', 'CalendarsController', ['except' => ['create', 'edit']]);
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::resource('memo', 'Api\ApiAdminMemoController');


    Route::group(['prefix' => 'enrollments'], function () {
        Route::post('create', [
            'as' => 'enrollments.create',
            'uses' => 'Api\ApiEnrollmentsController@store'
        ]);

        Route::get('payers/{transaction_type}', [
            'as' => 'enrollments.get_payers',
            'uses' => 'Api\ApiEnrollmentsController@getPayersList'
        ]);

        Route::group(['prefix' => 'original-signature'], function () {
            Route::post('send', [
                'as' => 'enrollments.original_signature.send',
                'uses' => 'Api\ApiEnrollmentsController@uploadOriginalSignaturePdf'
            ]);
        });

        Route::post('update/{enrollmentid}', [
            'as' => 'enrollments.update',
            'uses' => 'Api\ApiEnrollmentsController@updateEnrollment'
        ]);

        Route::get('retrieve/{enrollmentid}', [
            'as' => 'enrollments.retrieve',
            'uses' => 'Api\ApiEnrollmentsController@retrieveEnrollment'
        ]);

        Route::delete('delete', [
            'as' => 'enrollments.delete',
            'uses' => 'Api\ApiEnrollmentsController@destroyEnrollment'
        ]);

        Route::get('list/{userid?}', [
            'as' => 'enrollments.list',
            'uses' => 'Api\ApiEnrollmentsController@listEnrollments'
        ]);

        Route::get('apikey/{userid}', [
            'as' => 'enrollments.apikey',
            'uses' => 'Api\ApiEnrollmentsController@getDentalUserCompanyApiKey'
        ]);

        Route::get('type/{id}', [
            'as' => 'enrollments.type',
            'uses' => 'Api\ApiEnrollmentsController@getEnrollmentTransactionType'
        ]);

        Route::get('syncpayers', [
            'as' => 'enrollments.syncpayers',
            'uses' => 'Api\ApiEnrollmentsController@syncEnrollmentPayers'
        ]);
    });
});
