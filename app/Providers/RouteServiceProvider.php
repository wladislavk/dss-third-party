<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\StaticClasses\BindingSetter;
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
    private $resourceBindings = [
        'insurance-preauth' => \DentalSleepSolutions\Eloquent\Dental\InsurancePreauth::class,
        'insurance-types' => \DentalSleepSolutions\Eloquent\Dental\InsuranceType::class,
        'insurances' => \DentalSleepSolutions\Eloquent\Dental\Insurance::class,
        'intolerances' => \DentalSleepSolutions\Eloquent\Dental\Intolerance::class,
        'joint-exams' => \DentalSleepSolutions\Eloquent\Dental\JointExam::class,
        'joints' => \DentalSleepSolutions\Eloquent\Dental\Joint::class,
        'ledger-histories' => \DentalSleepSolutions\Eloquent\Dental\LedgerHistory::class,
        'ledger-notes' => \DentalSleepSolutions\Eloquent\Dental\LedgerNote::class,
        'ledger-payments' => \DentalSleepSolutions\Eloquent\Dental\LedgerPayment::class,
        'ledger-records' => \DentalSleepSolutions\Eloquent\Dental\LedgerRecord::class,
        'ledger-statements' => \DentalSleepSolutions\Eloquent\Dental\LedgerStatement::class,
        'ledgers' => \DentalSleepSolutions\Eloquent\Dental\Ledger::class,
        'letter-templates' => \DentalSleepSolutions\Eloquent\Dental\LetterTemplate::class,
        'letters' => \DentalSleepSolutions\Eloquent\Dental\Letter::class,
        'locations' => \DentalSleepSolutions\Eloquent\Dental\Location::class,
        'login-details' => \DentalSleepSolutions\Eloquent\Dental\LoginDetail::class,
        'logins' => \DentalSleepSolutions\Eloquent\Dental\Login::class,
        'mandibles' => \DentalSleepSolutions\Eloquent\Dental\Mandible::class,
        'maxillas' => \DentalSleepSolutions\Eloquent\Dental\Maxilla::class,
        'medical-histories' => \DentalSleepSolutions\Eloquent\Dental\MedicalHistory::class,
        'medications' => \DentalSleepSolutions\Eloquent\Dental\Medicament::class,
        'notes' => \DentalSleepSolutions\Eloquent\Dental\Note::class,
        'notifications' => \DentalSleepSolutions\Eloquent\Dental\Notification::class,
        'palpation' => \DentalSleepSolutions\Eloquent\Dental\Palpation::class,
        'patient-contacts' => \DentalSleepSolutions\Eloquent\Dental\PatientContact::class,
        'patient-insurances' => \DentalSleepSolutions\Eloquent\Dental\PatientInsurance::class,
        'patient-summaries' => \DentalSleepSolutions\Eloquent\Dental\PatientSummary::class,
        'patients' => \DentalSleepSolutions\Eloquent\Dental\Patient::class,
        'payers'       => \DentalSleepSolutions\Eloquent\Payer::class,
        'payment-reports' => \DentalSleepSolutions\Eloquent\Dental\PaymentReport::class,
        'place-services' => \DentalSleepSolutions\Eloquent\Dental\PlaceService::class,
        'plans' => \DentalSleepSolutions\Eloquent\Dental\Plan::class,
        'previous-treatments' => \DentalSleepSolutions\Eloquent\Dental\PreviousTreatment::class,
        'profile-images' => \DentalSleepSolutions\Eloquent\Dental\ProfileImage::class,
        'qualifiers' => \DentalSleepSolutions\Eloquent\Dental\Qualifier::class,
        'recipients' => \DentalSleepSolutions\Eloquent\Dental\Recipient::class,
        'referred-by-contacts' => \DentalSleepSolutions\Eloquent\Dental\ReferredByContact::class,
        'refunds' => \DentalSleepSolutions\Eloquent\Dental\Refund::class,
        'screener-epworth' => \DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth::class,
        'screeners' => \DentalSleepSolutions\Eloquent\Dental\Screener::class,
        'sleep-studies' => \DentalSleepSolutions\Eloquent\Dental\SleepStudy::class,
        'sleep-tests' => \DentalSleepSolutions\Eloquent\Dental\SleepTest::class,
        'sleeplabs' => \DentalSleepSolutions\Eloquent\Dental\Sleeplab::class,
        'social-histories' => \DentalSleepSolutions\Eloquent\Dental\SocialHistory::class,
        'soft-palates' => \DentalSleepSolutions\Eloquent\Dental\SoftPalate::class,
        'summaries' => \DentalSleepSolutions\Eloquent\Dental\Summary::class,
        'support-tickets' => \DentalSleepSolutions\Eloquent\Dental\SupportTicket::class,
        'symptoms' => \DentalSleepSolutions\Eloquent\Dental\Symptom::class,
        'tasks' => \DentalSleepSolutions\Eloquent\Dental\Task::class,
        'tmj-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam::class,
        'tongue-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam::class,
        'tonsils-clinical-exams' => \DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam::class,
        'users' => \DentalSleepSolutions\Eloquent\Dental\User::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->bindResource($binding->getRoute(), $binding->getModel());
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
     * @param  string $routeName   Url parameter name.
     * @param  string $modelClass Resource class name.
     * @return void
     */
    protected function bindResource($routeName, $modelClass)
    {
        $this->app['router']->bind($routeName, function ($id) use ($modelClass) {
            try {
                return $modelClass::findOrFail($id);
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
