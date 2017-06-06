<?php

namespace DentalSleepSolutions\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\LetterTriggerLauncher;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Helpers\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;

abstract class AbstractPatientEditor
{
    /** @var RegistrationEmailSender */
    private $registrationEmailSender;

    /** @var LetterTriggerLauncher */
    private $letterTriggerLauncher;

    /** @var PatientSummaryManager */
    protected $patientSummaryManager;

    public function __construct(
        RegistrationEmailSender $registrationEmailSender,
        LetterTriggerLauncher $letterTriggerLauncher,
        PatientSummaryManager $patientSummaryManager
    ) {
        $this->registrationEmailSender = $registrationEmailSender;
        $this->letterTriggerLauncher = $letterTriggerLauncher;
        $this->patientSummaryManager = $patientSummaryManager;
    }

    /**
     * @param array $formData
     * @param User $currentUser
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     * @return EditPatientResponseData
     */
    public function editPatient(
        array $formData,
        User $currentUser,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $responseData = new EditPatientResponseData();
        if ($unchangedPatient) {
            $responseData->currentPatientId = $unchangedPatient->patientid;
        }
        $this->updateDB($formData, $currentUser, $responseData, $requestData, $unchangedPatient);
        $this->doActionsAfterDBUpdate($currentUser, $requestData, $responseData->currentPatientId);
        $this->getResponseData($currentUser, $responseData, $requestData, $unchangedPatient);
        return $responseData;
    }

    /**
     * @param array $formData
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    private function updateDB(
        array $formData,
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $newFormData = $this->getNewFormData($currentUser, $requestData);
        $updatedFormData = array_merge($formData, $newFormData->toArray());
        $this->launchDBUpdatingMethods(
            $updatedFormData, $currentUser, $responseData, $requestData, $unchangedPatient
        );
        $this->patientSummaryManager->updatePatientSummary(
            $responseData->currentPatientId, $requestData->isInfoComplete
        );
    }

    /**
     * @param User $currentUser
     * @param EditPatientRequestData $requestData
     * @param int $patientId
     */
    private function doActionsAfterDBUpdate(
        User $currentUser,
        EditPatientRequestData $requestData,
        $patientId
    ) {
        $docId = $currentUser->getDocIdOrZero();
        $userType = $currentUser->getUserTypeOrZero();
        $userId = $currentUser->getUserIdOrZero();
        $this->letterTriggerLauncher->triggerLetters(
            $patientId, $docId, $userId, $userType, $requestData
        );
    }

    /**
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    private function getResponseData(
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $this->registrationEmailSender->sendRegistrationEmail(
            $responseData, $requestData, $unchangedPatient
        );
        $this->setResponseData($currentUser, $responseData, $requestData, $unchangedPatient);
    }

    /**
     * @param User $currentUser
     * @param EditPatientRequestData $requestData
     * @return NewPatientFormData
     */
    abstract protected function getNewFormData(
        User $currentUser,
        EditPatientRequestData $requestData
    );

    /**
     * @param array $formData
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    abstract protected function launchDBUpdatingMethods(
        array $formData,
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    );

    /**
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    abstract protected function setResponseData(
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    );
}
