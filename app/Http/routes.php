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
    Route::group(['prefix' => 'eligible'], function() {
        Route::get('payers', 'Eligible\EligibleController@getPayers');
    });

    Route::resource('corporate-contacts', 'CorporateContactsController', ['except' => ['create', 'edit']]);
    Route::resource('referred-by-contacts', 'ReferredByContactsController', ['except' => ['create', 'edit']]);
    Route::post('referred-by-contacts/edit/{contactId?}', 'ReferredByContactsController@editingContact');
    Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);
    Route::post('users/current', 'UsersController@getCurrentUserInfo');
    Route::post('users/course-staff', 'UsersController@getCourseStaff');
    Route::post('users/check', 'UsersController@check');
    Route::post('users/payment-reports', 'UsersController@getPaymentReports');
    Route::post('users/check-logout', 'UsersController@checkLogout');
    Route::post('users/letter-info', 'UsersController@getLetterInfo');
    Route::resource('tasks', 'TasksController', ['except' => ['create', 'edit']]);
    Route::post('tasks/{type}', 'TasksController@getType');
    Route::post('tasks/{type}/pid/{patientId}', 'TasksController@getTypeForPatient');
    Route::resource('home-sleep-tests', 'HomeSleepTestsController', ['except' => ['create', 'edit']]);
    Route::post('home-sleep-tests/uncompleted', 'HomeSleepTestsController@getUncompleted');
    Route::post('home-sleep-tests/{type}', 'HomeSleepTestsController@getByType');
    Route::resource('support-tickets', 'SupportTicketsController', ['except' => ['create', 'edit']]);
    Route::post('support-tickets/number', 'SupportTicketsController@getNumber');
    Route::resource('notifications', 'NotificationsController', ['except' => ['create', 'edit']]);
    Route::post('notifications/with-filter', 'NotificationsController@getWithFilter');
    Route::resource('summaries', 'SummariesController', ['except' => ['create', 'edit']]);
    Route::resource('admins', 'AdminsController', ['except' => ['create', 'edit']]);
    Route::resource('guide-settings', 'GuideSettingsController', ['except' => ['create', 'edit']]);
    Route::post('guide-settings/sort', 'GuideSettingsController@getAllOrderBy');
    Route::resource('guide-setting-options', 'GuideSettingOptionsController', ['except' => ['create', 'edit']]);
    Route::post('guide-setting-options/settingIds', 'GuideSettingOptionsController@getOptionsForSettingIds');
    Route::resource('guide-devices', 'GuideDevicesController', ['except' => ['create', 'edit']]);
    Route::post('guide-devices/with-images', 'GuideDevicesController@getWithImages');
    Route::resource('diagnostics', 'DiagnosticsController', ['except' => ['create', 'edit']]);
    Route::resource('documents', 'DocumentsController', ['except' => ['create', 'edit']]);
    Route::resource('document-categories', 'DocumentCategoriesController', ['except' => ['create', 'edit']]);
    Route::post('document-categories/active', 'DocumentCategoriesController@active');
    Route::resource('insurance-documents', 'InsuranceDocumentsController', ['except' => ['create', 'edit']]);
    Route::resource('faxes', 'FaxesController', ['except' => ['create', 'edit']]);
    Route::post('faxes/alerts', 'FaxesController@getAlerts');
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
    Route::post('insurances/rejected', 'InsurancesController@getRejected');
    Route::post('insurances/{type}', 'InsurancesController@getFrontOfficeClaims');
    Route::resource('insurance-files', 'InsuranceFilesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-histories', 'InsuranceHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('insurance-preauth', 'InsurancePreauthController', ['except' => ['create', 'edit']]);
    Route::post('insurance-preauth/vobs/find', 'InsurancePreauthController@find');
    Route::post('insurance-preauth/{type}', 'InsurancePreauthController@getByType');
    Route::post('insurance-preauth/pending-VOB', 'InsurancePreauthController@getPendingVOBByContactId');
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
    Route::post('letters/pending', 'LettersController@getPending');
    Route::post('letters/unmailed', 'LettersController@getUnmailed');
    Route::post('letters/delivered-for-contact', 'LettersController@getContactSentLetters');
    Route::post('letters/not-delivered-for-contact', 'LettersController@getContactPendingLetters');
    Route::post('letters/create-welcome-letter', 'LettersController@createWelcomeLetter');
    Route::post('letters/gen-date-of-intro', 'LettersController@getGeneratedDateOfIntroLetter');
    Route::resource('locations', 'LocationsController', ['except' => ['create', 'edit']]);
    Route::post('locations/by-doctor', 'LocationsController@getDoctorLocations');
    Route::resource('logins', 'LoginsController', ['except' => ['create', 'edit']]);
    Route::post('logout', 'LoginsController@logout');
    Route::resource('login-details', 'LoginDetailsController', ['except' => ['create', 'edit']]);
    Route::resource('mandibles', 'MandiblesController', ['except' => ['create', 'edit']]);
    Route::resource('maxillas', 'MaxillasController', ['except' => ['create', 'edit']]);
    Route::resource('medications', 'MedicationsController', ['except' => ['create', 'edit']]);
    Route::resource('notes', 'NotesController', ['except' => ['create', 'edit']]);
    Route::post('notes/unsigned', 'NotesController@getUnsigned');
    Route::resource('palpation', 'PalpationController', ['except' => ['create', 'edit']]);
    Route::resource('patient-contacts', 'PatientContactsController', ['except' => ['create', 'edit']]);
    Route::post('patient-contacts/current', 'PatientContactsController@getCurrent');
    Route::post('patient-contacts/number', 'PatientContactsController@getNumber');
    Route::resource('patient-insurances', 'PatientInsurancesController', ['except' => ['create', 'edit']]);
    Route::post('patient-insurances/current', 'PatientInsurancesController@getCurrent');
    Route::post('patient-insurances/number', 'PatientInsurancesController@getNumber');
    Route::resource('patient-summaries', 'PatientSummariesController', ['except' => ['create', 'edit']]);
    Route::post('patient-summaries/update-tracker-notes', 'PatientSummariesController@updateTrackerNotes');
    Route::resource('patients', 'PatientsController', ['except' => ['create', 'edit']]);
    Route::post('patients/with-filter', 'PatientsController@getWithFilter');
    Route::post('patients/number', 'PatientsController@getNumber');
    Route::post('patients/duplicates', 'PatientsController@getDuplicates');
    Route::post('patients/bounces', 'PatientsController@getBounces');
    Route::post('patients/list', 'PatientsController@getListPatients');
    Route::delete('patients-by-doctor/{patientId}', 'PatientsController@destroyForDoctor');
    Route::post('patients/find', 'PatientsController@find');
    Route::post('patients/referred-by-contact', 'PatientsController@getReferredByContact');
    Route::post('patients/by-contact', 'PatientsController@getByContact');
    Route::post('patients/filling-form', 'PatientsController@getDataForFillingPatientForm');
    Route::post('patients/referrers', 'PatientsController@getReferrers');
    Route::post('patients/edit/{patientId?}', 'PatientsController@editingPatient');
    Route::post('patients/check-email', 'PatientsController@checkEmail');
    Route::post('patients/reset-access-code/{patientId}', 'PatientsController@resetAccessCode');
    Route::post('patients/temp-pin-document/{patientId}', 'PatientsController@createTempPinDocument');
    Route::resource('payment-reports', 'PaymentReportsController', ['except' => ['create', 'edit']]);
    Route::post('payment-reports/number', 'PaymentReportsController@getNumber');
    Route::resource('place-services', 'PlaceServicesController', ['except' => ['create', 'edit']]);
    Route::resource('plans', 'PlansController', ['except' => ['create', 'edit']]);
    Route::resource('profile-images', 'ProfileImagesController', ['except' => ['create', 'edit']]);
    Route::post('profile-images/photo', 'ProfileImagesController@getProfilePhoto');
    Route::post('profile-images/insurance-card-image', 'ProfileImagesController@getInsuranceCardImage');
    Route::resource('symptoms', 'SymptomsController', ['except' => ['create', 'edit']]);
    Route::resource('previous-treatments', 'PreviousTreatmentsController', ['except' => ['create', 'edit']]);
    Route::resource('health-histories', 'HealthHistoriesController', ['except' => ['create', 'edit']]);
    Route::post('health-histories/with-filter', 'HealthHistoriesController@getWithFilter');
    Route::resource('social-histories', 'SocialHistoriesController', ['except' => ['create', 'edit']]);
    Route::resource('recipients', 'RecipientsController', ['except' => ['create', 'edit']]);
    Route::resource('sleep-tests', 'SleepTestsController', ['except' => ['create', 'edit']]);
    Route::resource('qualifiers', 'QualifiersController', ['except' => ['create', 'edit']]);
    Route::post('qualifiers/active', 'QualifiersController@getActive');
    Route::resource('refunds', 'RefundsController', ['except' => ['create', 'edit']]);
    Route::resource('chairs', 'ChairsController', ['except' => ['create', 'edit']]);
    Route::resource('screeners', 'ScreenersController', ['except' => ['create', 'edit']]);
    Route::resource('screener-epworth', 'ScreenerEpworthController', ['except' => ['create', 'edit']]);
    Route::resource('sleeplabs', 'SleeplabsController', ['except' => ['create', 'edit']]);
    Route::post('sleeplabs/list', 'SleeplabsController@getListOfSleeplabs');
    Route::post('sleeplabs/edit/{sleeplabId?}', 'SleeplabsController@editSleeplab');
    Route::resource('sleep-studies', 'SleepStudiesController', ['except' => ['create', 'edit']]);
    Route::resource('soft-palates', 'SoftPalatesController', ['except' => ['create', 'edit']]);
    Route::resource('claim-note-attachments', 'ClaimNoteAttachmentsController', ['except' => ['create', 'edit']]);
    Route::resource('complaints', 'ComplaintsController', ['except' => ['create', 'edit']]);
    Route::resource('custom-texts', 'CustomTextsController', ['except' => ['create', 'edit']]);
    Route::resource('contact-types', 'ContactTypesController', ['except' => ['create', 'edit']]);
    Route::post('contact-types/active-non-corporate', 'ContactTypesController@getActiveNonCorporate');
    Route::post('contact-types/physician', 'ContactTypesController@getPhysician');
    Route::post('contact-types/with-filter', 'ContactTypesController@getWithFilter');
    Route::resource('contacts', 'ContactsController', ['except' => ['create', 'edit']]);
    Route::post('contacts/find', 'ContactsController@find');
    Route::post('contacts/list-contacts-and-companies', 'ContactsController@getListContactsAndCompanies');
    Route::post('contacts/with-contact-type', 'ContactsController@getWithContactType');
    Route::post('contacts/insurance', 'ContactsController@getInsuranceContacts');
    Route::post('contacts/referred-by', 'ContactsController@getReferredByContacts');
    Route::post('contacts/corporate', 'ContactsController@getCorporateContacts');
    Route::resource('devices', 'DevicesController', ['except' => ['create', 'edit']]);
    Route::get('display-file/{filename}', 'DisplayingFileController@getFile');

    Route::get('payers/{payer_id}/required-fields', 'PayersController@requiredFields');
    // temporary, alias for the above to satisfy current JS
    Route::get('enrollments/requiredfields/{payer_id}', 'PayersController@requiredFields');
    Route::resource('payers', 'PayersController', ['except' => ['create', 'edit']]);
    Route::resource('appt-types', 'AppointmentTypesController', ['except' => ['create', 'edit']]);
    Route::resource('access-codes', 'AccessCodesController', ['except' => ['create', 'edit']]);
    Route::resource('calendars', 'CalendarsController', ['except' => ['create', 'edit']]);
    Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    Route::post('companies/company-logo', 'CompaniesController@getCompanyLogo');
    Route::post('companies/home-sleep-test', 'CompaniesController@getHomeSleepTestCompanies');
    Route::post('companies/billing-exclusive-company', 'CompaniesController@getBillingExclusiveCompany');
    Route::resource('allergens', 'AllergensController', ['except' => ['create', 'edit']]);
    Route::resource('charges', 'ChargesController', ['except' => ['create', 'edit']]);
    Route::resource('change-lists', 'ChangeListsController', ['except' => ['create', 'edit']]);
    Route::resource('memo', 'Api\ApiAdminMemoController');
    Route::post('memos/current', 'Api\ApiAdminMemoController@getCurrent');


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
