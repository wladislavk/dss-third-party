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

    Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);
    Route::post('users/check', 'UsersController@check');
    Route::get('users/{id}/type', 'UsersController@getUserType');

    Route::resource('admins', 'AdminsController', ['except' => ['create', 'edit']]);
    Route::resource('guide-settings', 'GuideSettingsController', ['except' => ['create', 'edit']]);
    Route::resource('guide-devices', 'GuideDevicesController', ['except' => ['create', 'edit']]);
    Route::resource('diagnostics', 'DiagnosticsController', ['except' => ['create', 'edit']]);
    Route::resource('documents', 'DocumentsController', ['except' => ['create', 'edit']]);
    Route::resource('document-categories', 'DocumentCategoriesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-documents', 'InsuranceDocumentsController', ['except' => ['create', 'edit']]);
    Route::resource('faxes', 'FaxesController', ['except' => ['create', 'edit']]);
    Route::resource('epworth-sleepiness-scale', 'EpworthSleepinessScaleController', ['except' => ['create', 'edit']]);
    Route::resource('tonsils-clinical-exams', 'TonsilsClinicalExamsController', ['except' => ['create', 'edit']]);
    Route::resource('tongue-clinical-exams', 'TongueClinicalExamsController', ['except' => ['create', 'edit']]);
    Route::resource('airway-evaluations', 'AirwayEvaluationsController', ['except' => ['create', 'edit']]);
    Route::resource('dental-clinical-exams', 'DentalClinicalExamsController', ['except' => ['create', 'edit']]);
    Route::resource('tmj-clinical-exams', 'TmjClinicalExamsController', ['except' => ['create', 'edit']]);
    Route::resource('fax-invoices', 'FaxInvoicesController', ['except' => ['create', 'edit']]);
    Route::resource('gag-reflexes', 'GagReflexesController', ['except' => ['create', 'edit']]);
    Route::resource('medical-histories', 'MedicalHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('image-types', 'ImageTypesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-diagnoses', 'InsuranceDiagnosesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-types', 'InsuranceTypesController', ['except' => ['create', 'edit']]);
    Route::resource('insurances', 'InsurancesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-files', 'InsuranceFilesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-histories', 'InsuranceHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-preauth', 'InsurancePreauthController', ['except' => ['create', 'edit']]);
    Route::resource('intolerances', 'IntolerancesController', ['except' => ['create', 'edit']]);
    Route::resource('joints', 'JointsController', ['except' => ['create', 'edit']]);
    Route::resource('joint-exams', 'JointExamsController', ['except' => ['create', 'edit']]);
    Route::resource('ledger-notes', 'LedgerNotesController', ['except' => ['create', 'edit']]);
    Route::resource('ledgers', 'LedgersController', ['except' => ['create', 'edit']]);
    Route::resource('ledger-histories', 'LedgerHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('ledger-payments', 'LedgerPaymentsController', ['except' => ['create', 'edit']]);
    Route::resource('ledger-records', 'LedgerRecordsController', ['except' => ['create', 'edit']]);
    Route::resource('letter-templates', 'LetterTemplatesController', ['except' => ['create', 'edit']]);
    Route::resource('custom-letter-templates', 'CustomLetterTemplatesController', ['except' => ['create', 'edit']]);
    Route::resource('letters', 'LettersController', ['except' => ['create', 'edit']]);
    Route::resource('locations', 'LocationsController', ['except' => ['create', 'edit']]);
    Route::resource('logins', 'LoginsController', ['except' => ['create', 'edit']]);
    Route::resource('login-details', 'LoginDetailsController', ['except' => ['create', 'edit']]);
    Route::resource('mandibles', 'MandiblesController', ['except' => ['create', 'edit']]);
    Route::resource('maxillas', 'MaxillasController', ['except' => ['create', 'edit']]);
    Route::resource('medications', 'MedicationsController', ['except' => ['create', 'edit']]);
    Route::resource('notes', 'NotesController', ['except' => ['create', 'edit']]);
    Route::resource('palpation', 'PalpationController', ['except' => ['create', 'edit']]);
    Route::resource('patient-contacts', 'PatientContactsController', ['except' => ['create', 'edit']]);
    Route::resource('patient-insurances', 'PatientInsurancesController', ['except' => ['create', 'edit']]);
    Route::resource('patient-summaries', 'PatientSummariesController', ['except' => ['create', 'edit']]);
    Route::resource('patients', 'PatientsController', ['except' => ['create', 'edit']]);
    Route::resource('payment-reports', 'PaymentReportsController', ['except' => ['create', 'edit']]);
    Route::resource('place-services', 'PlaceServicesController', ['except' => ['create', 'edit']]);
    Route::resource('plans', 'PlansController', ['except' => ['create', 'edit']]);
    Route::resource('profile-images', 'ProfileImagesController', ['except' => ['create', 'edit']]);
    Route::resource('symptoms', 'SymptomsController', ['except' => ['create', 'edit']]);
    Route::resource('previous-treatments', 'PreviousTreatmentsController', ['except' => ['create', 'edit']]);
    Route::resource('health-histories', 'HealthHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('social-histories', 'SocialHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('recipients', 'RecipientsController', ['except' => ['create', 'edit']]);
    Route::resource('sleep-tests', 'SleepTestsController', ['except' => ['create', 'edit']]);
    Route::resource('qualifiers', 'QualifiersController', ['except' => ['create', 'edit']]);
    Route::resource('refunds', 'RefundsController', ['except' => ['create', 'edit']]);
    Route::resource('chairs', 'ChairsController', ['except' => ['create', 'edit']]);
    Route::resource('screeners', 'ScreenersController', ['except' => ['create', 'edit']]);
    Route::resource('screener-epworth', 'ScreenerEpworthController', ['except' => ['create', 'edit']]);
    Route::resource('sleeplabs', 'SleeplabsController', ['except' => ['create', 'edit']]);
    Route::resource('sleep-studies', 'SleepStudiesController', ['except' => ['create', 'edit']]);
    Route::resource('soft-palates', 'SoftPalatesController', ['except' => ['create', 'edit']]);
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
    Route::resource('allergens', 'AllergensController', ['except' => ['create', 'edit']]);
    Route::resource('charges', 'ChargesController', ['except' => ['create', 'edit']]);
    Route::resource('change-lists', 'ChangeListsController', ['except' => ['create', 'edit']]);
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
