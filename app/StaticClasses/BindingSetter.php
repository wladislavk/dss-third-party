<?php

namespace DentalSleepSolutions\StaticClasses;

use DentalSleepSolutions\Eloquent;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Structs\Bindings;

class BindingSetter
{
    const EXTERNAL_MODEL_KEY = 0;
    const EXTERNAL_RESOURCE_KEY = 1;
    const EXTERNAL_REPOSITORY_KEY = 2;

    const MODELS = [
        Eloquent\Models\Dental\AccessCode::class,
        Eloquent\Models\Admin::class,
        Eloquent\Models\Dental\AirwayEvaluation::class,
        Eloquent\Models\Dental\Allergen::class,
        Eloquent\Models\Dental\AppointmentType::class,
        Eloquent\Models\Dental\Calendar::class,
        Eloquent\Models\Dental\Chair::class,
        Eloquent\Models\Dental\ChangeList::class,
        Eloquent\Models\Dental\Charge::class,
        Eloquent\Models\Dental\ClaimNoteAttachment::class,
        Eloquent\Models\Company::class,
        Eloquent\Models\Dental\Complaint::class,
        Eloquent\Models\Dental\Contact::class,
        Eloquent\Models\Dental\ContactType::class,
        Eloquent\Models\Dental\CorporateContact::class,
        Eloquent\Models\Dental\CustomLetterTemplate::class,
        Eloquent\Models\Dental\CustomText::class,
        Eloquent\Models\Dental\DentalClinicalExam::class,
        Eloquent\Models\Dental\Device::class,
        Eloquent\Models\Dental\Diagnostic::class,
        Eloquent\Models\Dental\Document::class,
        Eloquent\Models\Dental\DocumentCategory::class,
        Eloquent\Models\EdxCertificate::class,
        Eloquent\Models\Dental\EpworthHomeSleepTest::class,
        Eloquent\Models\Dental\EpworthSleepinessScale::class,
        Eloquent\Models\Dental\ExternalCompany::class,
        Eloquent\Models\Dental\ExternalUser::class,
        Eloquent\Models\Dental\Fax::class,
        Eloquent\Models\Dental\FaxInvoice::class,
        Eloquent\Models\Filemanager::class,
        Eloquent\Models\FlowsheetSegment::class,
        Eloquent\Models\Dental\GagReflex::class,
        Eloquent\Models\Dental\GuideDevice::class,
        Eloquent\Models\Dental\GuideSetting::class,
        Eloquent\Models\Dental\GuideSettingOption::class,
        Eloquent\Models\Dental\HealthHistory::class,
        Eloquent\Models\Dental\HomeSleepTest::class,
        Eloquent\Models\Dental\ImageType::class,
        Eloquent\Models\Dental\Insurance::class,
        Eloquent\Models\Dental\InsuranceDiagnosis::class,
        Eloquent\Models\Dental\InsuranceDocument::class,
        Eloquent\Models\Dental\InsuranceFile::class,
        Eloquent\Models\Dental\InsuranceHistory::class,
        Eloquent\Models\Dental\InsurancePreauth::class,
        Eloquent\Models\Dental\InsuranceType::class,
        Eloquent\Models\Dental\Intolerance::class,
        Eloquent\Models\Dental\Joint::class,
        Eloquent\Models\Dental\JointExam::class,
        Eloquent\Models\Dental\LedgerHistory::class,
        Eloquent\Models\Dental\LedgerNote::class,
        Eloquent\Models\Dental\LedgerPayment::class,
        Eloquent\Models\Dental\LedgerRecord::class,
        Eloquent\Models\Dental\LedgerStatement::class,
        Eloquent\Models\Dental\Ledger::class,
        Eloquent\Models\Dental\LetterTemplate::class,
        Eloquent\Models\Dental\Letter::class,
        Eloquent\Models\Dental\Location::class,
        Eloquent\Models\Dental\LoginDetail::class,
        Eloquent\Models\Dental\Login::class,
        Eloquent\Models\Dental\Mandible::class,
        Eloquent\Models\Dental\Maxilla::class,
        Eloquent\Models\Dental\MedicalHistory::class,
        Eloquent\Models\Dental\Medicament::class,
        Eloquent\Models\Dental\Note::class,
        Eloquent\Models\Dental\Notification::class,
        Eloquent\Models\Dental\Palpation::class,
        Eloquent\Models\Dental\PatientContact::class,
        Eloquent\Models\Dental\PatientInsurance::class,
        Eloquent\Models\Dental\PatientSummary::class,
        Eloquent\Models\Dental\Patient::class,
        Eloquent\Models\Payer::class,
        Eloquent\Models\Dental\PaymentReport::class,
        Eloquent\Models\Dental\PlaceService::class,
        Eloquent\Models\Dental\Plan::class,
        Eloquent\Models\Dental\PreviousTreatment::class,
        Eloquent\Models\Dental\ProfileImage::class,
        Eloquent\Models\Dental\Qualifier::class,
        Eloquent\Models\Dental\Recipient::class,
        Eloquent\Models\Dental\ReferredByContact::class,
        Eloquent\Models\Dental\Refund::class,
        Eloquent\Models\Dental\ScreenerEpworth::class,
        Eloquent\Models\Dental\Screener::class,
        Eloquent\Models\Dental\Sleeplab::class,
        Eloquent\Models\Dental\SleepStudy::class,
        Eloquent\Models\Dental\SleepTest::class,
        Eloquent\Models\Dental\SocialHistory::class,
        Eloquent\Models\Dental\SupportAttachment::class,
        Eloquent\Models\Dental\SoftPalate::class,
        Eloquent\Models\Dental\Summary::class,
        Eloquent\Models\Dental\SummarySleeplab::class,
        Eloquent\Models\Dental\SupportCategory::class,
        Eloquent\Models\Dental\SupportResponse::class,
        Eloquent\Models\Dental\SupportTicket::class,
        Eloquent\Models\Dental\Symptom::class,
        Eloquent\Models\Dental\Task::class,
        Eloquent\Models\Dental\TmjClinicalExam::class,
        Eloquent\Models\Dental\Tongue::class,
        Eloquent\Models\Dental\TongueClinicalExam::class,
        Eloquent\Models\Dental\TonsilsClinicalExam::class,
        Eloquent\Models\Dental\TransactionCode::class,
        Eloquent\Models\Dental\TypeService::class,
        Eloquent\Models\Dental\User::class,
        Eloquent\Models\Dental\UserCompany::class,
        Eloquent\Models\Dental\UserHstCompany::class,
        Eloquent\Models\Dental\UserSignature::class,
        Eloquent\Models\Dental\Uvula::class,
    ];

    const EXTERNAL_BINDINGS = [
        Eloquent\Models\Dental\ExternalCompanyUser::class,
        Eloquent\Models\Dental\ExternalPatient::class,
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
            $namingConvention = new BindingNamingConvention($binding);
            $bindingObject = new Bindings();
            $bindingObject
                ->setModel($binding)
                ->setRepository($namingConvention->getRepository())
            ;
            $bindingObjects[] = $bindingObject;
        }
        return $bindingObjects;
    }
}
