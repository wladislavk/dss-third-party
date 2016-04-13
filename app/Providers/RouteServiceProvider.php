<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Routing\Router;
use DentalSleepSolutions\Exceptions\ResourceNotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'DentalSleepSolutions\Http\Controllers';

    /**
     * Route model bindings for the resources.
     *
     * @var array
     */
    protected $resourceBindings = [
        'q-page2-surgeries' => \DentalSleepSolutions\Eloquent\Dental\QPage2Surgery::class,
        'guide-settings' => \DentalSleepSolutions\Eloquent\Dental\GuideSetting::class,
        'guide-devices' => \DentalSleepSolutions\Eloquent\Dental\GuideDevice::class,
        'diagnostics' => \DentalSleepSolutions\Eloquent\Dental\Diagnostic::class,
        'documents' => \DentalSleepSolutions\Eloquent\Dental\Document::class,
        'document-categories' => \DentalSleepSolutions\Eloquent\Dental\DocumentCategory::class,
        'insurance-documents' => \DentalSleepSolutions\Eloquent\Dental\InsuranceDocument::class,
        'faxes' => \DentalSleepSolutions\Eloquent\Dental\Fax::class,
        'epworth-sleepiness-scale' => \DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale::class,
        'tonsils-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam::class,
        'tongue-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam::class,
        'airway-evaluations' => \DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation::class,
        'dental-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam::class,
        'tmj-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam::class,
        'fax-invoices' => \DentalSleepSolutions\Eloquent\Dental\FaxInvoice::class,
        'gag-reflexes' => \DentalSleepSolutions\Eloquent\Dental\GagReflex::class,
        'medical-histories' => \DentalSleepSolutions\Eloquent\Dental\MedicalHistory::class,
        'image-types' => \DentalSleepSolutions\Eloquent\Dental\ImageType::class,
        'insurance-diagnoses' => \DentalSleepSolutions\Eloquent\Dental\InsDiagnosis::class,
        'insurance-types' => \DentalSleepSolutions\Eloquent\Dental\InsuranceType::class,
        'insurances' => \DentalSleepSolutions\Eloquent\Dental\Insurance::class,
        'insurance-files' => \DentalSleepSolutions\Eloquent\Dental\InsuranceFile::class,
        'insurance-histories' => \DentalSleepSolutions\Eloquent\Dental\InsuranceHistory::class,
        'insurance-preauth' => \DentalSleepSolutions\Eloquent\Dental\InsurancePreauth::class,
        'intolerances' => \DentalSleepSolutions\Eloquent\Dental\Intolerance::class,
        'joints' => \DentalSleepSolutions\Eloquent\Dental\Joint::class,
        'joint-exams' => \DentalSleepSolutions\Eloquent\Dental\JointExam::class,
        'ledger-notes' => \DentalSleepSolutions\Eloquent\Dental\LedgerNote::class,
        'ledgers' => \DentalSleepSolutions\Eloquent\Dental\Ledger::class,
        'ledger-histories' => \DentalSleepSolutions\Eloquent\Dental\LedgerHistory::class,
        'ledger-payments' => \DentalSleepSolutions\Eloquent\Dental\LedgerPayment::class,
        'ledger-records' => \DentalSleepSolutions\Eloquent\Dental\LedgerRecord::class,
        'letter-templates' => \DentalSleepSolutions\Eloquent\Dental\LetterTemplate::class,
        'custom-letter-templates' => \DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate::class,
        'letters' => \DentalSleepSolutions\Eloquent\Dental\Letter::class,
        'locations' => \DentalSleepSolutions\Eloquent\Dental\Location::class,
        'logins' => \DentalSleepSolutions\Eloquent\Dental\Login::class,
        'login-details' => \DentalSleepSolutions\Eloquent\Dental\LoginDetail::class,
        'mandibles' => \DentalSleepSolutions\Eloquent\Dental\Mandible::class,
        'maxillas' => \DentalSleepSolutions\Eloquent\Dental\Maxilla::class,
        'medications' => \DentalSleepSolutions\Eloquent\Dental\Medicament::class,
        'notes' => \DentalSleepSolutions\Eloquent\Dental\Note::class,
        'palpation' => \DentalSleepSolutions\Eloquent\Dental\Palpation::class,
        'patient-contacts' => \DentalSleepSolutions\Eloquent\Dental\PatientContact::class,
        'patient-insurances' => \DentalSleepSolutions\Eloquent\Dental\PatientInsurance::class,
        'patient-summaries' => \DentalSleepSolutions\Eloquent\Dental\PatientSummary::class,
        'patients' => \DentalSleepSolutions\Eloquent\Dental\Patient::class,
        'payment-reports' => \DentalSleepSolutions\Eloquent\Dental\PaymentReport::class,
        'place-services' => \DentalSleepSolutions\Eloquent\Dental\PlaceService::class,
        'plans' => \DentalSleepSolutions\Eloquent\Dental\Plan::class,
        'profile-images' => \DentalSleepSolutions\Eloquent\Dental\ProfileImage::class,
        'symptoms' => \DentalSleepSolutions\Eloquent\Dental\Symptom::class,
        'previous-treatments' => \DentalSleepSolutions\Eloquent\Dental\PreviousTreatment::class,
        'health-histories' => \DentalSleepSolutions\Eloquent\Dental\HealthHistory::class,
        'social-histories' => \DentalSleepSolutions\Eloquent\Dental\SocialHistory::class,
        'recipients' => \DentalSleepSolutions\Eloquent\Dental\Recipient::class,
        'sleep-tests' => \DentalSleepSolutions\Eloquent\Dental\SleepTest::class,
        'qualifiers' => \DentalSleepSolutions\Eloquent\Dental\Qualifier::class,
        'refunds' => \DentalSleepSolutions\Eloquent\Dental\Refund::class,
        'chairs' => \DentalSleepSolutions\Eloquent\Dental\Chair::class,
        'screeners' => \DentalSleepSolutions\Eloquent\Dental\Screener::class,
        'screener-epworth' => \DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth::class,
        'sleeplabs' => \DentalSleepSolutions\Eloquent\Dental\Sleeplab::class,
        'sleep-studies' => \DentalSleepSolutions\Eloquent\Dental\SleepStudy::class,
        'soft-palates' => \DentalSleepSolutions\Eloquent\Dental\SoftPalate::class,
        'appt-types' => \DentalSleepSolutions\Eloquent\Dental\AppointmentType::class,
        'payers'       => \DentalSleepSolutions\Eloquent\Payer::class,
        'access-codes' => \DentalSleepSolutions\Eloquent\Dental\AccessCode::class,
        'claim-note-attachments' => \DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment::class,
        'complaints' => \DentalSleepSolutions\Eloquent\Dental\Complaint::class,
        'custom-texts' => \DentalSleepSolutions\Eloquent\Dental\CustomText::class,
        'devices' => \DentalSleepSolutions\Eloquent\Dental\Device::class,
        'contacts' => \DentalSleepSolutions\Eloquent\Dental\Contact::class,
        'contact-types' => \DentalSleepSolutions\Eloquent\Dental\ContactType::class,
        'companies'     => \DentalSleepSolutions\Eloquent\Company::class,
        'calendars'     => \DentalSleepSolutions\Eloquent\Dental\Calendar::class,
        'admins'        => \DentalSleepSolutions\Eloquent\Admin::class,
        'allergens' => \DentalSleepSolutions\Eloquent\Dental\Allergen::class,
        'change-lists' => \DentalSleepSolutions\Eloquent\Dental\ChangeList::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        foreach ($this->resourceBindings as $key => $resource) {
            $this->bindResource($key, $resource);
        }

        $router->bind('payer_id', function ($uid) {
            try {
                return $this->app[\DentalSleepSolutions\Contracts\Repositories\Payers::class]->findByUid($uid);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFound('Requested resource does not exist.');
            }
        });

        parent::boot($router);
    }

    /**
     * Bind resource to a route and let controllers use its instance rather than id.
     *
     * @param  string $key   Url parameter name.
     * @param  string $class Resource class name.
     * @return void
     */
    protected function bindResource($key, $class)
    {
        $this->app['router']->bind($key, function ($id) use ($class) {
            try {
                return $class::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFound('Requested resource does not exist.');
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
