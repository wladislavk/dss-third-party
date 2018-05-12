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
    const MODEL_NAMESPACE = 'DentalSleepSolutions\Eloquent\Models\\';

    const MODELS = [
        'Dental\AccessCode',
        'Admin',
        'Dental\AdvancedPainTmdExam',
        'Dental\AirwayEvaluation',
        'Dental\Allergen',
        'Dental\ApiPermission',
        'Dental\ApiPermissionResource',
        'Dental\ApiPermissionResourceGroup',
        'Dental\AppointmentSummary',
        'Dental\AppointmentType',
        'Dental\AssessmentPlanExam',
        'Dental\Calendar',
        'Dental\Chair',
        'Dental\ChangeList',
        'Dental\Charge',
        'Dental\ClaimElectronic',
        'Dental\ClaimNote',
        'Dental\ClaimNoteAttachment',
        'Dental\ClaimText',
        'Company',
        'Dental\Complaint',
        'Dental\Contact',
        'Dental\ContactType',
        'Dental\CorporateContact',
        'Dental\CustomLetterTemplate',
        'Dental\CustomText',
        'Dental\DentalClinicalExam',
        'Dental\Device',
        'Dental\Diagnostic',
        'Dental\DoctorPalpation',
        'Dental\Document',
        'Dental\DocumentCategory',
        'EdxCertificate',
        'Dental\EpworthHomeSleepTest',
        'Dental\EpworthSleepinessScale',
        'Dental\EvaluationManagementExam',
        'Dental\ExternalCompany',
        'Dental\ExternalUser',
        'Dental\ExtraPercaseInvoice',
        'Dental\Fax',
        'Dental\FaxInvoice',
        'Filemanager',
        'FlowsheetSegment',
        'Dental\Flowsheet',
        'Dental\FlowsheetStep',
        'Dental\FlowsheetNextStep',
        'Dental\Form',
        'Dental\GagReflex',
        'Dental\GuideDevice',
        'Dental\GuideSetting',
        'Dental\GuideSettingOption',
        'Dental\HealthHistory',
        'Dental\HomeSleepTest',
        'Dental\ImageType',
        'Dental\Insurance',
        'Dental\InsuranceDiagnosis',
        'Dental\InsuranceDocument',
        'Dental\InsuranceFile',
        'Dental\InsuranceHistory',
        'Dental\InsurancePreauth',
        'Dental\InsuranceType',
        'Dental\Intolerance',
        'Dental\Joint',
        'Dental\JointExam',
        'Dental\LedgerHistory',
        'Dental\LedgerNote',
        'Dental\LedgerPayment',
        'Dental\LedgerRecord',
        'Dental\LedgerStatement',
        'Dental\Ledger',
        'Dental\LetterTemplate',
        'Dental\Letter',
        'Dental\Location',
        'Dental\LoginDetail',
        'Dental\Login',
        'Dental\Mandible',
        'Dental\Maxilla',
        'Dental\MedicalHistory',
        'Dental\Medicament',
        'Dental\MissingTooth',
        'Dental\ModifierCode',
        'Dental\NasalPassage',
        'Dental\NewFlowsheet',
        'Dental\Note',
        'Dental\Notification',
        'Dental\PainTmdExam',
        'Dental\Palpation',
        'Dental\PatientContact',
        'Dental\PatientInsurance',
        'Dental\PatientSummary',
        'Dental\Patient',
        'Payer',
        'Dental\PaymentReport',
        'Dental\PercaseInvoice',
        'Dental\PlaceService',
        'Dental\Plan',
        'Dental\PlanText',
        'Dental\PreviousTreatment',
        'Dental\ProfileImage',
        'Dental\Qualifier',
        'Dental\QPage2Surgery',
        'Dental\Recipient',
        'Dental\ReferredByContact',
        'Dental\Refund',
        'Dental\ScreenerEpworth',
        'Dental\Screener',
        'Dental\Sleeplab',
        'Dental\SleepStudy',
        'Dental\SleepTest',
        'Dental\SocialHistory',
        'Dental\SupportAttachment',
        'Dental\SoftPalate',
        'Dental\Summary',
        'Dental\SummarySleeplab',
        'Dental\SupportCategory',
        'Dental\SupportResponse',
        'Dental\SupportTicket',
        'Dental\Symptom',
        'Dental\Task',
        'Dental\TeethExam',
        'Dental\Thorton',
        'Dental\TmjClinicalExam',
        'Dental\Tongue',
        'Dental\TongueClinicalExam',
        'Dental\TonsilsClinicalExam',
        'Dental\TransactionCode',
        'Dental\TypeService',
        'Dental\User',
        'Dental\UserCompany',
        'Dental\UserHstCompany',
        'Dental\UserSignature',
        'Dental\Uvula',
    ];

    const EXTERNAL_BINDINGS = [
        'Dental\ExternalCompanyUser',
        'Dental\ExternalPatient',
    ];

    /**
     * @param string|null $modelName
     * @return Bindings[]
     * @throws \DentalSleepSolutions\Exceptions\NamingConventionException
     */
    public static function setBindings($modelName = null)
    {
        $bindingObjects = [];
        $models = self::selectModels($modelName);

        foreach ($models as $modelWithoutNamespace) {
            $model = self::MODEL_NAMESPACE . $modelWithoutNamespace;
            $namingConvention = new BindingNamingConvention($model);
            $bindingObject = new Bindings();
            $bindingObject
                ->setModel($model)
                ->setController($namingConvention->getController())
                ->setRepository($namingConvention->getRepository())
                ->setRequest($namingConvention->getRequest())
            ;

            if ($namingConvention->getRequestTransformer()) {
                $bindingObject->setTransformer($namingConvention->getRequestTransformer());
            }

            $bindingObjects[] = $bindingObject;
        }
        return $bindingObjects;
    }

    /**
     * @return Bindings[]
     * @throws \DentalSleepSolutions\Exceptions\NamingConventionException
     */
    public static function setExternalBindings()
    {
        $bindingObjects = [];
        foreach (self::EXTERNAL_BINDINGS as $bindingWithoutNamespace) {
            $binding = self::MODEL_NAMESPACE . $bindingWithoutNamespace;
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

    /**
     * @param string|null $modelName
     * @return array
     */
    protected static function selectModels($modelName = null)
    {
        if (is_null($modelName)) {
            return self::MODELS;
        }
        if (in_array($modelName, self::MODELS)) {
            return [$modelName];
        }
        $namespace = 'Dental\\';
        if (in_array($namespace . $modelName, self::MODELS)) {
            return [$namespace . $modelName];
        }
        return [];
    }
}
