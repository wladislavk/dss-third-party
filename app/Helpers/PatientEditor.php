<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RememberEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Libraries\Password;

class PatientEditor
{
    const UNREGISTERED_STATUS = 0;
    const REGISTRATION_EMAILED_STATUS = 1;
    const REGISTERED_STATUS = 2;

    const DOC_FIELDS = [
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

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

    /** @var TreatmentCompleteTrigger */
    private $treatmentCompleteTrigger;

    /** @var LettersToMDTrigger */
    private $lettersToMDTrigger;

    /** @var LetterToPatientTrigger */
    private $letterToPatientTrigger;

    /** @var UpdateEmailHandler */
    private $updateEmailHandler;

    /** @var RememberEmailHandler */
    private $rememberEmailHandler;

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    /** @var PreauthHelper */
    private $preauthHelper;

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var UniqueLoginGenerator */
    private $uniqueLoginGenerator;

    /** @var LetterManager */
    private $letterManager;

    /** @var InsurancePreauth */
    private $insurancePreauthResource;

    /** @var Summary */
    private $summariesResource;

    /** @var User */
    private $userResource;

    /** @var Patient */
    private $patientResource;

    /** @var PatientSummary */
    private $patientSummaryResource;

    public function __construct(
        TreatmentCompleteTrigger $treatmentCompleteTrigger,
        LettersToMDTrigger $lettersToMDTrigger,
        LetterToPatientTrigger $letterToPatientTrigger,
        UpdateEmailHandler $updateEmailHandler,
        RememberEmailHandler $rememberEmailHandler,
        RegistrationEmailHandler $registrationEmailHandler,
        PreauthHelper $preauthHelper,
        SimilarHelper $similarHelper,
        UniqueLoginGenerator $uniqueLoginGenerator,
        LetterManager $letterManager,
        InsurancePreauth $insurancePreauthResource,
        Summary $summariesResource,
        User $userResource,
        Patient $patientResource,
        PatientSummary $patientSummaryResource
    ) {
        $this->treatmentCompleteTrigger = $treatmentCompleteTrigger;
        $this->lettersToMDTrigger = $lettersToMDTrigger;
        $this->letterToPatientTrigger = $letterToPatientTrigger;
        $this->updateEmailHandler = $updateEmailHandler;
        $this->rememberEmailHandler = $rememberEmailHandler;
        $this->registrationEmailHandler = $registrationEmailHandler;
        $this->preauthHelper = $preauthHelper;
        $this->similarHelper = $similarHelper;
        $this->uniqueLoginGenerator = $uniqueLoginGenerator;
        $this->letterManager = $letterManager;
        $this->insurancePreauthResource = $insurancePreauthResource;
        $this->summariesResource = $summariesResource;
        $this->userResource = $userResource;
        $this->patientResource = $patientResource;
        $this->patientSummaryResource = $patientSummaryResource;
    }

    public function editPatient(
        User $currentUser,
        $emailTypesForSending,
        $pressedButtons,
        array $patientFormData,
        $ip,
        $patientLocation,
        $patientId = null
    ) {
        $docId = 0;
        if ($currentUser->docid) {
            $docId = $currentUser->docid;
        }
        $userType = 0;
        if ($currentUser->user_type) {
            $userType = $currentUser->user_type;
        }
        $userId = 0;
        if ($currentUser->id) {
            $userId = $currentUser->id;
        }

        // get doc info by id
        $docInfo = $this->userResource->getWithFilter('use_patient_portal', ['userid' => $docId]);

        $docPatientPortal = false;
        if (count($docInfo)) {
            $docPatientPortal = $docInfo[0]->use_patient_portal;
        }

        $usePatientPortal = 0;
        if (!empty($patientFormData['use_patient_portal'])) {
            $usePatientPortal = $patientFormData['use_patient_portal'];
        }
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);

        // need to add logic for logging actions
        // linkRequestData

        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin($patientFormData);

        $isUpdateAction = true;

        /** @var Patient|null $unchangedPatient */
        $unchangedPatient = null;
        if ($patientId) {
            $unchangedPatient = $this->patientResource->find($patientId);
            $responseData = $this->updatePatient(
                $unchangedPatient, $patientFormData, $patientId, $userId, $docId, $emailTypesForSending, $pressedButtons, $uniqueLogin, $docPatientPortal, $usePatientPortal, $currentUser
            );
        } else {
            $isUpdateAction = false;
            $responseData = $this->createPatient(
                $patientFormData, $userId, $docId, $ip, $uniqueLogin, $patientLocation
            );
            $patientId = $responseData['created_patient_id'];
        }

        $mdContacts = $this->formMdContacts($patientFormData);
        $params = [
            LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts,
        ];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);

        if (!empty($patientFormData['introletter']) && $patientFormData['introletter'] == 1) {
            $this->letterToPatientTrigger->trigger($patientId, $docId, $userId);
        }

        if ($this->shouldSendRegistrationEmail($docPatientPortal, $usePatientPortal, $emailTypesForSending)) {
            $responseData = $this->sendRegistrationEmail(
                $responseData, $patientFormData, $unchangedPatient, $patientId, $isUpdateAction
            );
        }

        $isInfoComplete = $this->isInfoComplete($patientFormData);

        // determine whether patient info has been completely set
        $this->updatePatientSummary(
            $patientId, 'patient_info', $isInfoComplete
        );
        return $responseData;
    }

    private function formMdContacts(array $patientFormData)
    {
        $mdContacts = [];
        foreach (self::DOC_FIELDS as $field) {
            $newMdContact = 0;
            if (!empty($patientFormData[$field])) {
                $newMdContact = $patientFormData[$field];
            }
            $mdContacts[] = $newMdContact;
        }
        return $mdContacts;
    }

    private function shouldSendRegistrationEmail($docPatientPortal, $usePatientPortal, array $emailTypesForSending)
    {
        if (
            $emailTypesForSending
            &&
            !empty($emailTypesForSending['registration'])
            &&
            $docPatientPortal
            &&
            $usePatientPortal
        ) {
            return true;
        }
        return false;
    }

    private function sendRegistrationEmail(
        array $responseData,
        array $patientFormData,
        Patient $unchangedPatient,
        $patientId,
        $isUpdateAction
    ) {
        $message = 'Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.';
        if ($patientFormData['email'] && $patientFormData['cell_phone']) {
            $oldEmail = '';
            if ($isUpdateAction && $unchangedPatient) {
                $oldEmail = $unchangedPatient->email;
            }
            $this->registrationEmailHandler->handleEmail($patientId, $patientFormData['email'], $oldEmail);
            $message = 'The registration mail was successfully sent.';
        }

        $responseData['mails'] = [
            'registration_mail' => $message
        ];
        return $responseData;
    }

    private function updatePatient(
        Patient $unchangedPatient,
        array $patientFormData,
        $patientId,
        $userId,
        $docId,
        $emailTypesForSending,
        $pressedButtons,
        $uniqueLogin,
        $docPatientPortal,
        $usePatientPortal,
        User $currentUser
    ) {
        $responseData = $this->handleEmails(
            $unchangedPatient, $patientFormData, $patientId, $emailTypesForSending, $docPatientPortal, $usePatientPortal
        );

        if ($patientFormData['email'] != $unchangedPatient->email) {
            $patientFormData['email_bounce'] = 0;
        }

        // update patient
        $this->patientResource->updatePatient($patientId, $patientFormData);
        // update email of parent patient for all his children
        $this->patientResource->updateChildrenPatients($patientId, ['email' => $patientFormData['email']]);

        // remove pending vobs if insurance info has changed
        $hasInsuranceInfoChanged = $this->checkIfInsuranceInfoWasChanged(
            $patientFormData, $unchangedPatient
        );
        if ($hasInsuranceInfoChanged) {
            $userName = '';
            if ($currentUser->name) {
                $userName = $currentUser->name;
            }
            $updatedVob = $this->insurancePreauthResource->updateVob($patientId, $userName);
            if ($updatedVob) {
                $insurancePreauth = $this->preauthHelper
                    ->createVerificationOfBenefits($patientId, $userId);
                if ($insurancePreauth) {
                    $insurancePreauth->save();
                }
            }
        }

        if (!empty($patientLocation)) {
            $this->updatePatientSummaryWithLocation($patientId, $patientLocation);
        }

        if ($unchangedPatient->login == '') {
            $this->patientResource->updatePatient($patientId, ['login' => $uniqueLogin]);
        }

        // TODO: if it is required need to rewrite it to the new Laravel structure:
        // $this->setDateCompleted();

        if ($this->wasReferrerChanged($unchangedPatient, $patientFormData)) {
            $this->letterManager->manageLetters(
                $patientId, $docId, $userId, $unchangedPatient, $patientFormData
            );
        }
        if ($pressedButtons) {
            $responseData = $this->handlePressedButtons($responseData, $pressedButtons, $patientId);
        }
        $responseData['status'] = 'Edited Successfully';
        return $responseData;
    }

    private function handleEmails(
        Patient $unchangedPatient,
        array $patientFormData,
        $patientId,
        array $emailTypesForSending,
        $docPatientPortal,
        $usePatientPortal
    ) {
        $responseData = [];
        // TODO: need to rewrite this logic from legacy code to the new Laravel structure
        if (
            $unchangedPatient->registration_status == self::REGISTERED_STATUS
            &&
            $patientFormData['email'] != $unchangedPatient->email
        ) {
            // notify the user about changing his email
            $this->updateEmailHandler->handleEmail(
                $patientId, $patientFormData['email'], $unchangedPatient->email
            );

            $responseData['mails'] = [
                'updated_mail' => 'The mail about changing patient email was successfully sent.'
            ];
        } elseif ($emailTypesForSending && !empty($emailTypesForSending['reminder'])) {
            // send reminder email
            $this->rememberEmailHandler->handleEmail($patientId, $patientFormData['email']);

            $responseData['mails'] = [
                'reminder_mail' => 'The reminding mail was successfully sent.'
            ];
        } elseif (
            $emailTypesForSending
            &&
            empty($emailTypesForSending['registration'])
            &&
            $unchangedPatient->registration_status == self::REGISTRATION_EMAILED_STATUS
            &&
            $patientFormData['email'] != $unchangedPatient['email']
        ) {
            if ($docPatientPortal && $usePatientPortal) {
                // send registration email if email is updated and not registered
                $this->registrationEmailHandler->handleEmail($patientId, $patientFormData['email']);
            }

            $responseData['mails'] = [
                'registration_mail' => 'Your email address was updated and not registered. The registration mail was successfully sent.'
            ];
        }
        return $responseData;
    }

    private function updatePatientSummaryWithLocation($patientId, $patientLocation)
    {
        $summaries = $this->summariesResource->getWithFilter(null, ['patientid' => $patientId]);
        if (count($summaries)) {
            $summaryData = ['location' => $patientLocation];
            $this->summariesResource->updateForPatient($patientId, $summaryData);
            return;
        }
        $summaryData = [
            'location'  => $patientLocation,
            'patientid' => $patientId,
        ];
        $this->summariesResource->create($summaryData);
    }

    private function handlePressedButtons(array $responseData, array $pressedButtons, $patientId)
    {
        if ($pressedButtons['send_hst']) {
            $responseData['redirect_to'] = 'hst_request_co.php?ed=' . $patientId;
            return $responseData;
        }
        if ($pressedButtons['send_pin_code']) {
            $responseData['send_pin_code'] = true;
        }
        return $responseData;
    }

    private function createPatient(
        array $patientFormData,
        $userId,
        $docId,
        $ip,
        $uniqueLogin,
        $patientLocation
    ) {
        $salt = '';
        $password = '';
        if ($patientFormData['ssn']) {
            $salt = Password::createSalt();
            $password = preg_replace('/\D/', '', $patientFormData['ssn']);
            $password = Password::genPassword($password, $salt);
        }

        $middleName = '';
        if (!empty($patientFormData['middlename'])) {
            $middleName = ucfirst($patientFormData['middlename']);
        }
        $patientFormData = array_merge($patientFormData, [
            'login'      => $uniqueLogin,
            'password'   => $password,
            'salt'       => $salt,
            'userid'     => $userId,
            'docid'      => $docId,
            'ip_address' => $ip,
            // set filters
            'firstname'  => ucfirst($patientFormData['firstname']),
            'lastname'   => ucfirst($patientFormData['lastname']),
            'middlename' => $middleName,
        ]);

        $createdPatientId = $this->patientResource->create($patientFormData)->patientid;
        $responseData['created_patient_id'] = $createdPatientId;

        if ($patientLocation) {
            $this->summariesResource->create([
                'location'  => $patientLocation,
                'patientid' => $createdPatientId
            ]);
        }

        $similarPatients = $this->similarHelper->getSimilarPatients($createdPatientId, $docId);

        if (count($similarPatients)) {
            $responseData['redirect_to'] = 'duplicate_patients.php?pid=' . $createdPatientId;
        } else {
            $responseData['status'] = 'Patient "' . $patientFormData['firstname'] . ' ' . $patientFormData['lastname'] . '" was added successfully.';
        }

        return $responseData;
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

    private function checkIfInsuranceInfoWasChanged(
        array $patientFormData,
        Patient $unchangedPatient
    ) {
        foreach (self::INSURANCE_INFO_FIELDS as $field) {
            if ($unchangedPatient->$field != $patientFormData[$field]) {
                return true;
            }
        }
        return false;
    }

    private function updatePatientSummary(
        $patientId = 0,
        $column = '',
        $isInfoComplete = false
    ) {
        if (empty($patientId) || empty($column)) {
            return;
        }
        $patientSummary = $this->patientSummaryResource->find($patientId);
        if (!empty($patientSummary)) {
            $patientSummary->$column = $isInfoComplete;
            $patientSummary->save();
        } else {
            $this->patientSummaryResource->create([
                'pid'   => $patientId,
                $column => $isInfoComplete
            ]);
        }
    }

    private function isInfoComplete(array $patientFormData)
    {
        $patientEmail = false;
        if (!empty($patientFormData['email'])) {
            $patientEmail = true;
        }
        if (
            ($patientEmail || $this->hasPatientPhone($patientFormData))
            &&
            !empty($patientFormData['add1'])
            &&
            !empty($patientFormData['city'])
            &&
            !empty($patientFormData['state'])
            &&
            !empty($patientFormData['zip'])
            &&
            !empty($patientFormData['dob'])
            &&
            !empty($patientFormData['gender'])
        ) {
            return true;
        }
        return false;
    }

    private function hasPatientPhone(array $patientFormData)
    {
        if (
            !empty($patientFormData['home_phone'])
            ||
            !empty($patientFormData['work_phone'])
            ||
            !empty($patientFormData['cell_phone'])
        ) {
            return true;
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
}
