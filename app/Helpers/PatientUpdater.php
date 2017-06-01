<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Structs\EditPatientResponseData;

class PatientUpdater
{
    // TODO: it is highly likely that this URL is no longer relevant
    const REDIRECT_URL = 'hst_request_co.php?ed=';

    const INSURANCE_INFO_FIELDS = [
        'p_m_relation',
        'p_m_partyfname',
        'p_m_partylname',
        'ins_dob',
        'p_m_ins_type',
        'p_m_ins_ass',
        'p_m_ins_id',
        'p_m_ins_grp',
        'p_m_ins_plan',
    ];

    /** @var PatientUpdateMailer */
    private $patientUpdateMailer;

    /** @var PreauthHelper */
    private $preauthHelper;

    /** @var LetterManager */
    private $letterManager;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var Patient */
    private $patientModel;

    /** @var InsurancePreauth */
    private $insurancePreauthModel;

    public function __construct(
        PatientUpdateMailer $patientUpdateMailer,
        PreauthHelper $preauthHelper,
        LetterManager $letterManager,
        PatientSummaryManager $patientSummaryManager,
        Patient $patientModel,
        InsurancePreauth $insurancePreauthModel
    ) {
        $this->patientUpdateMailer = $patientUpdateMailer;
        $this->preauthHelper = $preauthHelper;
        $this->letterManager = $letterManager;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->patientModel = $patientModel;
        $this->insurancePreauthModel = $insurancePreauthModel;
    }

    public function updatePatient(
        EditPatientResponseData $responseData,
        Patient $unchangedPatient,
        array $patientFormData,
        User $currentUser,
        $patientId,
        array $emailTypesForSending,
        array $pressedButtons,
        $uniqueLogin,
        $hasPatientPortal,
        $patientLocation
    ) {
        $responseData->mails = $this->patientUpdateMailer->handleEmails(
            $unchangedPatient, $patientFormData['email'], $patientId, $emailTypesForSending, $hasPatientPortal
        );

        $this->patientModel->updatePatient($patientId, $patientFormData);
        $this->patientModel->updateChildrenPatients($patientId, ['email' => $patientFormData['email']]);

        $hasInsuranceInfoChanged = $this->checkIfInsuranceInfoWasChanged(
            $patientFormData, $unchangedPatient
        );
        if ($hasInsuranceInfoChanged) {
            $this->removePendingVerificationOfBenefits($currentUser, $patientId, $currentUser->getUserIdOrZero());
        }

        $this->patientSummaryManager->updateSummaryWithLocation($patientId, $patientLocation);
        if ($unchangedPatient->login == '') {
            $this->patientModel->updatePatient($patientId, ['login' => $uniqueLogin]);
        }

        // TODO: if it is required need to rewrite it to the new Laravel structure:
        // $this->setDateCompleted();

        if ($this->wasReferrerChanged($unchangedPatient, $patientFormData)) {
            $this->letterManager->manageLetters(
                $patientId,
                $currentUser->getDocIdOrZero(),
                $currentUser->getUserIdOrZero(),
                $unchangedPatient,
                $patientFormData['referred_source'],
                $patientFormData['referred_by']
            );
        }
        if ($pressedButtons) {
            $this->handlePressedButtons($responseData, $pressedButtons, $patientId);
        }
        $responseData->status = EditPatientResponseData::PATIENT_EDITED_STATUS;
    }

    private function removePendingVerificationOfBenefits(User $currentUser, $patientId, $userId)
    {
        $userName = '';
        if ($currentUser->name) {
            $userName = $currentUser->name;
        }
        $updatedVerificationOfBenefits = $this->insurancePreauthModel->updateVob($patientId, $userName);
        if ($updatedVerificationOfBenefits) {
            $insurancePreauth = $this->preauthHelper
                ->createVerificationOfBenefits($patientId, $userId);
            if ($insurancePreauth) {
                $insurancePreauth->save();
            }
        }
    }

    private function handlePressedButtons(
        EditPatientResponseData $responseData,
        array $pressedButtons,
        $patientId
    ) {
        if ($pressedButtons['send_hst']) {
            $responseData->redirectTo = self::REDIRECT_URL . $patientId;
            return;
        }
        if ($pressedButtons['send_pin_code']) {
            $responseData->sendPinCode = true;
        }
    }

    private function checkIfInsuranceInfoWasChanged(
        array $patientFormData,
        Patient $unchangedPatient
    ) {
        foreach (self::INSURANCE_INFO_FIELDS as $field) {
            if (
                property_exists($unchangedPatient, $field)
                &&
                isset($patientFormData[$field])
                &&
                $unchangedPatient->$field != $patientFormData[$field]
            ) {
                return true;
            }
        }
        return false;
    }

    private function wasReferrerChanged(Patient $unchangedPatient, array $patientFormData)
    {
        if ($unchangedPatient->referred_by != $patientFormData['referred_by']
            ||
            $unchangedPatient->referred_source != $patientFormData['referred_source']
        ) {
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
