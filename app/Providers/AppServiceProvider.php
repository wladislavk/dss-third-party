<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Eloquent;
use Illuminate\Support\ServiceProvider;
use DentalSleepSolutions\Contracts\Resources;
use DentalSleepSolutions\Contracts\Repositories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\Payers::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Payer::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\AppointmentTypes::class,
            \DentalSleepSolutions\Eloquent\Dental\AppointmentType::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\AppointmentType::class,
            \DentalSleepSolutions\Eloquent\Dental\AppointmentType::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\AccessCodes::class,
            \DentalSleepSolutions\Eloquent\Dental\AccessCode::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\AccessCode::class,
            \DentalSleepSolutions\Eloquent\Dental\AccessCode::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $bindings = [
            Eloquent\Admin::class => [Repositories\Admins::class, Resources\Admin::class],
            Eloquent\Payer::class => [Repositories\Payers::class, Resources\Device::class],
            Eloquent\Dental\CustomText::class => [Repositories\CustomTexts::class, Resources\CustomText::class],
            Eloquent\Company::class => [Repositories\Companies::class, Resources\Company::class],
            Eloquent\Dental\Device::class => [Repositories\Devices::class, Resources\Device::class],
            Eloquent\Dental\Contact::class => [Repositories\Contacts::class, Resources\Contact::class],
            Eloquent\Dental\ContactType::class => [Repositories\ContactTypes::class, Resources\ContactType::class],
            Eloquent\Dental\Calendar::class => [Repositories\Calendars::class, Resources\Calendar::class],
            Eloquent\Dental\Allergen::class => [Repositories\Allergens::class, Resources\Allergen::class],
            Eloquent\Dental\Charge::class => [Repositories\Charges::class, Resources\Charge::class],
            Eloquent\Dental\ChangeList::class => [Repositories\ChangeLists::class, Resources\ChangeList::class],
            Eloquent\Dental\GuideSetting::class => [Repositories\GuideSettings::class, Resources\GuideSetting::class],
            Eloquent\Dental\GuideDevice::class => [Repositories\GuideDevices::class, Resources\GuideDevice::class],
            Eloquent\Dental\Diagnostic::class => [Repositories\Diagnostics::class, Resources\Diagnostic::class],
            Eloquent\Dental\Document::class => [Repositories\Documents::class, Resources\Document::class],
            Eloquent\Dental\DocumentCategory::class => [Repositories\DocumentCategories::class, Resources\DocumentCategory::class],
            Eloquent\Dental\InsuranceDocument::class => [Repositories\InsuranceDocuments::class, Resources\InsuranceDocument::class],
            Eloquent\Dental\Fax::class => [Repositories\Faxes::class, Resources\Fax::class],
            Eloquent\Dental\EpworthSleepinessScale::class => [Repositories\EpworthSleepinessScale::class, Resources\EpworthSleepinessScale::class],
            Eloquent\Dental\TonsilsClinicalExam::class => [Repositories\TonsilsClinicalExams::class, Resources\TonsilsClinicalExam::class],
            Eloquent\Dental\TongueClinicalExam::class => [Repositories\TongueClinicalExams::class, Resources\TongueClinicalExam::class],
            Eloquent\Dental\AirwayEvaluation::class => [Repositories\AirwayEvaluations::class, Resources\AirwayEvaluation::class],
        ];


        $this->app->bind(
            'DentalSleepSolutions\\Contracts\\Repositories\\Complaints',
            'DentalSleepSolutions\\Eloquent\\Dental\\Complaint'
        );

        foreach ($bindings as $concrete => $contracts) {
            foreach ((array)$contracts as $contract) {
                $this->app->bind($contract, $concrete);
            }
        }

        $this->app->bind(
            'DentalSleepSolutions\\Contracts\\Repositories\\ClaimNoteAttachments',
            'DentalSleepSolutions\\Eloquent\\Dental\\ClaimNoteAttachment'
        );
    }
}
