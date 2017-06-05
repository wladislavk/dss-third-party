<?php

namespace DentalSleepSolutions\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\LetterManager;
use DentalSleepSolutions\Helpers\LetterTriggerLauncher;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Helpers\PatientUpdateMailer;
use DentalSleepSolutions\Helpers\PendingVOBRemover;
use DentalSleepSolutions\Helpers\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\PressedButtons;

class PatientUpdater extends AbstractPatientEditor
{
    // TODO: it is likely that this URL is no longer relevant
    const REDIRECT_URL = 'hst_request_co.php?ed=';

    /** @var PatientUpdateMailer */
    private $patientUpdateMailer;

    /** @var LetterManager */
    private $letterManager;

    /** @var PendingVOBRemover */
    private $pendingVOBRemover;

    public function __construct(
        RegistrationEmailSender $registrationEmailSender,
        LetterTriggerLauncher $letterTriggerLauncher,
        PatientSummaryManager $patientSummaryManager,
        PatientUpdateMailer $patientUpdateMailer,
        LetterManager $letterManager,
        PendingVOBRemover $pendingVOBRemover
    ) {
        parent::__construct(
            $registrationEmailSender, $letterTriggerLauncher, $patientSummaryManager
        );
        $this->patientUpdateMailer = $patientUpdateMailer;
        $this->letterManager = $letterManager;
        $this->pendingVOBRemover = $pendingVOBRemover;
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
        return new NewPatientFormData();
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
        $docId = $currentUser->getDocIdOrZero();
        $userId = $currentUser->getUserIdOrZero();

        if ($this->wasInsuranceInfoChanged($requestData, $unchangedPatient)) {
            $this->pendingVOBRemover->removePendingVerificationOfBenefits(
                $currentUser, $unchangedPatient->patientid, $userId
            );
        }
        $this->patientSummaryManager->updateSummaryWithLocation(
            $unchangedPatient->patientid, $requestData->patientLocation
        );

        // TODO: if it is required, need to rewrite it to the new Laravel structure
        // $this->setDateCompleted();

        if ($this->wasReferrerChanged($requestData, $unchangedPatient)) {
            $this->letterManager->manageLetters(
                $docId, $userId, $unchangedPatient, $requestData->referrer
            );
        }
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
        $responseData->mails = $this->patientUpdateMailer->handleEmails($unchangedPatient, $requestData);
        if ($requestData->pressedButtons) {
            $this->handlePressedButtons($responseData, $requestData->pressedButtons, $unchangedPatient);
        }
        $responseData->status = EditPatientResponseData::PATIENT_EDITED_STATUS;
    }

    /**
     * @param EditPatientResponseData $responseData
     * @param PressedButtons $pressedButtons
     * @param Patient $unchangedPatient
     */
    private function handlePressedButtons(
        EditPatientResponseData $responseData,
        PressedButtons $pressedButtons,
        Patient $unchangedPatient
    ) {
        if ($pressedButtons->sendHst) {
            $responseData->redirectTo = self::REDIRECT_URL . $unchangedPatient->patientid;
            return;
        }
        if ($pressedButtons->sendPinCode) {
            $responseData->sendPinCode = true;
        }
    }

    /**
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     * @return bool
     */
    private function wasInsuranceInfoChanged(
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        foreach ($requestData->insuranceInfo as $field => $value) {
            if (property_exists($unchangedPatient, $field)
                &&
                $unchangedPatient->$field != $value
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     * @return bool
     */
    private function wasReferrerChanged(
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        if ($unchangedPatient->referred_by != $requestData->referrer->referredBy) {
            return true;
        }
        if ($unchangedPatient->referred_source != $requestData->referrer->source) {
            return true;
        }
        return false;
    }

    private function setDateCompleted()
    {
        // TODO: if it is required need to rewrite it to the new Laravel structure:
        /*
        if (!empty($_POST['copyreqdate'])) {
          $dateCompleted = date('Y-m-d', strtotime($_POST['copyreqdate']));
        } else {
          $dateCompleted = date('Y-m-d');
        }

        $s1 = "UPDATE dental_flow_pg2_info SET date_completed = '" . $dateCompleted . "' WHERE patientid='".intval($_POST['ed'])."' AND stepid='1';";
        $db->query($s1);
        */
    }
}
