<?php

namespace DentalSleepSolutions\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\LetterTriggerLauncher;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Helpers\RegistrationEmailSender;
use DentalSleepSolutions\Helpers\SimilarHelper;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;

class PatientCreator extends AbstractPatientEditor
{
    // TODO: it is likely that this URL is no longer relevant
    const DUPLICATE_URL = 'duplicate_patients.php?pid=';

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var Patient */
    private $patientModel;

    public function __construct(
        RegistrationEmailSender $registrationEmailSender,
        LetterTriggerLauncher $letterTriggerLauncher,
        PatientSummaryManager $patientSummaryManager,
        SimilarHelper $similarHelper,
        PatientSummaryManager $patientSummaryManager,
        PasswordGenerator $passwordGenerator,
        Patient $patientModel
    ) {
        parent::__construct(
            $registrationEmailSender, $letterTriggerLauncher, $patientSummaryManager
        );
        $this->similarHelper = $similarHelper;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->passwordGenerator = $passwordGenerator;
        $this->patientModel = $patientModel;
    }

    /**
     * @param User $currentUser
     * @param EditPatientRequestData $requestData
     * @return NewPatientFormData
     */
    protected function getNewFormData(
        User $currentUser,
        EditPatientRequestData $requestData
    ) {
        $newPatientFormData = new NewPatientFormData();
        if ($requestData->ssn) {
            $this->passwordGenerator->generatePassword($requestData->ssn, $newPatientFormData);
        }
        $newPatientFormData->userId = $currentUser->getUserIdOrZero();
        $newPatientFormData->docId = $currentUser->getDocIdOrZero();
        $newPatientFormData->ipAddress = $requestData->ip;
        $newPatientFormData->patientName = $requestData->patientName;
        return $newPatientFormData;
    }

    /**
     * @param array $formData
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    protected function launchDBUpdatingMethods(
        array $formData,
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $responseData->currentPatientId = $this->patientModel->create($formData);
    }

    /**
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    protected function setResponseData(
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $this->patientSummaryManager->createSummary($responseData->currentPatientId, $requestData->patientLocation);

        $similarPatients = $this->similarHelper
            ->getSimilarPatients($responseData->currentPatientId, $currentUser->getDocIdOrZero());

        $fullName = $requestData->patientName->firstName . ' ' . $requestData->patientName->lastName;
        if (count($similarPatients)) {
            $responseData->redirectTo = self::DUPLICATE_URL . $responseData->currentPatientId;
            return;
        }
        $responseData->status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, $fullName);
    }
}
