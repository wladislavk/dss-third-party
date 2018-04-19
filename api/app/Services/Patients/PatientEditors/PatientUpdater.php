<?php

namespace DentalSleepSolutions\Services\Patients\PatientEditors;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\Letters\LetterManager;
use DentalSleepSolutions\Services\Letters\LetterTriggerLauncher;
use DentalSleepSolutions\Services\Patients\PatientSummaryManager;
use DentalSleepSolutions\Services\Patients\PatientUpdateMailer;
use DentalSleepSolutions\Services\InsurancePreauth\PendingVOBRemover;
use DentalSleepSolutions\Services\Emails\RegistrationEmailSender;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\EditPatientIntendedActions;

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
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
        if ($requestData->intendedActions) {
            $this->handleIntendedActions($responseData, $requestData->intendedActions, $unchangedPatient);
        }
        $responseData->status = EditPatientResponseData::PATIENT_EDITED_STATUS;
    }

    /**
     * @param EditPatientResponseData $responseData
     * @param EditPatientIntendedActions $intendedActions
     * @param Patient $unchangedPatient
     */
    private function handleIntendedActions(
        EditPatientResponseData $responseData,
        EditPatientIntendedActions $intendedActions,
        Patient $unchangedPatient
    ) {
        if ($intendedActions->sendHst) {
            $responseData->redirectTo = self::REDIRECT_URL . $unchangedPatient->patientid;
            return;
        }
        if ($intendedActions->sendPinCode) {
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
            if (
                isset($unchangedPatient->$field)
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
