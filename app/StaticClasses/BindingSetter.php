<?php

namespace DentalSleepSolutions\StaticClasses;

use DentalSleepSolutions\Eloquent;
use DentalSleepSolutions\Contracts\Repositories;
use DentalSleepSolutions\Contracts\Resources;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Structs\Bindings;
use DentalSleepSolutions\Http\Controllers;
use DentalSleepSolutions\Http\Requests;

class BindingSetter
{
    const EXTERNAL_MODEL_KEY = 0;
    const EXTERNAL_RESOURCE_KEY = 1;
    const EXTERNAL_REPOSITORY_KEY = 2;

    const MODELS = [
        Eloquent\Dental\AccessCode::class,
        Eloquent\Admin::class,
        Eloquent\Dental\AirwayEvaluation::class,
        Eloquent\Dental\Allergen::class,
        Eloquent\Dental\AppointmentType::class,
        Eloquent\Dental\Calendar::class,
        Eloquent\Dental\Chair::class,
        Eloquent\Dental\ChangeList::class,
        Eloquent\Dental\Charge::class,
        Eloquent\Dental\ClaimNoteAttachment::class,
        Eloquent\Company::class,
        Eloquent\Dental\Complaint::class,
        Eloquent\Dental\Contact::class,
        Eloquent\Dental\ContactType::class,
        Eloquent\Dental\CorporateContact::class,
        Eloquent\Dental\CustomLetterTemplate::class,
        Eloquent\Dental\CustomText::class,
        Eloquent\Dental\DentalClinicalExam::class,
        Eloquent\Dental\Device::class,
        Eloquent\Dental\Diagnostic::class,
        Eloquent\Dental\Document::class,
        Eloquent\Dental\DocumentCategory::class,
        Eloquent\Dental\EpworthSleepinessScale::class,
        Eloquent\Dental\ExternalCompany::class,
        Eloquent\Dental\ExternalUser::class,
        Eloquent\Dental\Fax::class,
        Eloquent\Dental\FaxInvoice::class,
        Eloquent\Dental\GagReflex::class,
        Eloquent\Dental\GuideDevice::class,
        Eloquent\Dental\GuideSetting::class,
        Eloquent\Dental\GuideSettingOption::class,
        Eloquent\Dental\HealthHistory::class,
        Eloquent\Dental\HomeSleepTest::class,
        Eloquent\Dental\ImageType::class,
        Eloquent\Dental\Insurance::class,
        Eloquent\Dental\InsuranceDiagnosis::class,
        Eloquent\Dental\InsuranceDocument::class,
        Eloquent\Dental\InsuranceFile::class,
        Eloquent\Dental\InsuranceHistory::class,
        Eloquent\Dental\InsurancePreauth::class,
        Eloquent\Dental\InsuranceType::class,
        Eloquent\Dental\Intolerance::class,
        Eloquent\Dental\Joint::class,
        Eloquent\Dental\JointExam::class,
        Eloquent\Dental\LedgerHistory::class,
        Eloquent\Dental\LedgerNote::class,
        Eloquent\Dental\LedgerPayment::class,
        Eloquent\Dental\LedgerRecord::class,
        Eloquent\Dental\LedgerStatement::class,
        Eloquent\Dental\Ledger::class,
        Eloquent\Dental\LetterTemplate::class,
        Eloquent\Dental\Letter::class,
        Eloquent\Dental\Location::class,
        Eloquent\Dental\LoginDetail::class,
        Eloquent\Dental\Login::class,
        Eloquent\Dental\Mandible::class,
        Eloquent\Dental\Maxilla::class,
        Eloquent\Dental\MedicalHistory::class,
        Eloquent\Dental\Medicament::class,
        Eloquent\Dental\Note::class,
        Eloquent\Dental\Notification::class,
        Eloquent\Dental\Palpation::class,
        Eloquent\Dental\PatientContact::class,
        Eloquent\Dental\PatientInsurance::class,
        Eloquent\Dental\PatientSummary::class,
        Eloquent\Dental\Patient::class,
        Eloquent\Payer::class,
        Eloquent\Dental\PaymentReport::class,
        Eloquent\Dental\PlaceService::class,
        Eloquent\Dental\Plan::class,
        Eloquent\Dental\PreviousTreatment::class,
        Eloquent\Dental\ProfileImage::class,
        Eloquent\Dental\Qualifier::class,
        Eloquent\Dental\Recipient::class,
        Eloquent\Dental\ReferredByContact::class,
        Eloquent\Dental\Refund::class,
        Eloquent\Dental\ScreenerEpworth::class,
        Eloquent\Dental\Screener::class,
        Eloquent\Dental\Sleeplab::class,
        Eloquent\Dental\SleepStudy::class,
        Eloquent\Dental\SleepTest::class,
        Eloquent\Dental\SocialHistory::class,
        Eloquent\Dental\SoftPalate::class,
        Eloquent\Dental\Summary::class,
        Eloquent\Dental\SupportTicket::class,
        Eloquent\Dental\Symptom::class,
        Eloquent\Dental\Task::class,
        Eloquent\Dental\TmjClinicalExam::class,
        Eloquent\Dental\TongueClinicalExam::class,
        Eloquent\Dental\TonsilsClinicalExam::class,
        Eloquent\Dental\User::class,
    ];

    const EXTERNAL_BINDINGS = [
        [
            Eloquent\Dental\ExternalCompanyUser::class,
            Resources\ExternalCompanyUser::class,
            Repositories\ExternalCompanyUsers::class,
        ],
        [
            Eloquent\Dental\ExternalPatient::class,
            Resources\ExternalPatient::class,
            Repositories\ExternalPatients::class,
        ],
    ];

    /**
     * @return Bindings[]
     */
    public static function setBindings()
    {
        $bindingObjects = [];
        foreach (self::MODELS as $model) {
            $namingConvention = new BindingNamingConvention($model);
            $bindingObject = new Bindings();
            $bindingObject
                ->setModel($model)
                ->setController($namingConvention->getController())
                ->setResource($namingConvention->getResource())
                ->setRepository($namingConvention->getRepository())
                ->setRequest($namingConvention->getRequest())
            ;
            $bindingObjects[] = $bindingObject;
        }
        return $bindingObjects;
    }

    /**
     * @return Bindings[]
     */
    public static function setExternalBindings()
    {
        $bindingObjects = [];
        foreach (self::EXTERNAL_BINDINGS as $binding) {
            $bindingObject = new Bindings();
            $bindingObject
                ->setModel($binding[self::EXTERNAL_MODEL_KEY])
                ->setResource($binding[self::EXTERNAL_RESOURCE_KEY])
                ->setRepository($binding[self::EXTERNAL_REPOSITORY_KEY])
            ;
            $bindingObjects[] = $bindingObject;
        }
        return $bindingObjects;
    }
}
