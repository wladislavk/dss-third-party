<?php

namespace DentalSleepSolutions\Services\Patients\PatientEditors;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Services\Letters\LetterTriggerLauncher;
use DentalSleepSolutions\Services\Auth\PasswordGenerator;
use DentalSleepSolutions\Services\Patients\PatientSummaryManager;
use DentalSleepSolutions\Services\Emails\RegistrationEmailSender;
use DentalSleepSolutions\Services\Patients\SimilarHelper;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;

class PatientCreator extends AbstractPatientEditor
{
    // TODO: it is likely that this URL is no longer relevant
    const DUPLICATE_URL = 'duplicate_patients.php?pid=';

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(
        RegistrationEmailSender $registrationEmailSender,
        LetterTriggerLauncher $letterTriggerLauncher,
        PatientSummaryManager $patientSummaryManager,
        UserRepository $userRepository,
        SimilarHelper $similarHelper,
        PasswordGenerator $passwordGenerator,
        PatientRepository $patientRepository
    ) {
        parent::__construct(
            $registrationEmailSender, $letterTriggerLauncher, $patientSummaryManager, $userRepository
        );
        $this->similarHelper = $similarHelper;
        $this->passwordGenerator = $passwordGenerator;
        $this->patientRepository = $patientRepository;
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
            $basePassword = preg_replace('/\D/', '', $requestData->ssn);
            $this->passwordGenerator->generateLegacyPassword($basePassword, $newPatientFormData);
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function launchDBUpdatingMethods(
        array $formData,
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        /** @var Patient $newPatient */
        $newPatient = $this->patientRepository->create($formData);
        $responseData->currentPatientId = $newPatient->patientid;
    }

    /**
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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

        if (count($similarPatients)) {
            $responseData->redirectTo = self::DUPLICATE_URL . $responseData->currentPatientId;
            return;
        }
        $fullName = $requestData->patientName->firstName . ' ' . $requestData->patientName->lastName;
        $responseData->status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, $fullName);
    }
}
