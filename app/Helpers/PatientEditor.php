<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientResponseData;

class PatientEditor
{
    const DOC_FIELDS = [
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    /** @var PatientCreator */
    private $patientCreator;

    /** @var PatientUpdater */
    private $patientUpdater;

    /** @var TreatmentCompleteTrigger */
    private $treatmentCompleteTrigger;

    /** @var LettersToMDTrigger */
    private $lettersToMDTrigger;

    /** @var LetterToPatientTrigger */
    private $letterToPatientTrigger;

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    /** @var UniqueLoginGenerator */
    private $uniqueLoginGenerator;

    /** @var PatientFormDataChecker */
    private $patientFormDataChecker;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var PatientPortalRetriever */
    private $patientPortalRetriever;

    /** @var Patient */
    private $patientModel;

    public function __construct(
        PatientCreator $patientCreator,
        PatientUpdater $patientUpdater,
        TreatmentCompleteTrigger $treatmentCompleteTrigger,
        LettersToMDTrigger $lettersToMDTrigger,
        LetterToPatientTrigger $letterToPatientTrigger,
        RegistrationEmailHandler $registrationEmailHandler,
        UniqueLoginGenerator $uniqueLoginGenerator,
        PatientFormDataChecker $patientFormDataChecker,
        PatientSummaryManager $patientSummaryManager,
        PatientPortalRetriever $patientPortalRetriever,
        Patient $patientModel
    ) {
        $this->patientCreator = $patientCreator;
        $this->patientUpdater = $patientUpdater;
        $this->treatmentCompleteTrigger = $treatmentCompleteTrigger;
        $this->lettersToMDTrigger = $lettersToMDTrigger;
        $this->letterToPatientTrigger = $letterToPatientTrigger;
        $this->registrationEmailHandler = $registrationEmailHandler;
        $this->uniqueLoginGenerator = $uniqueLoginGenerator;
        $this->patientFormDataChecker = $patientFormDataChecker;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->patientPortalRetriever = $patientPortalRetriever;
        $this->patientModel = $patientModel;
    }

    public function editPatient(
        User $currentUser,
        array $emailTypesForSending,
        array $pressedButtons,
        array $patientFormData,
        $ip,
        $patientLocation,
        $patientId = null
    ) {
        $docId = $currentUser->getDocIdOrZero();
        $userType = $currentUser->getUserTypeOrZero();
        $userId = $currentUser->getUserIdOrZero();

        $hasPatientPortal = false;
        if (isset($patientFormData['use_patient_portal'])) {
            $hasPatientPortal = $this->patientPortalRetriever
                ->hasPatientPortal($docId, $patientFormData['use_patient_portal']);
        }

        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);

        // TODO: need to add logic for logging actions

        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin(
            $patientFormData['firstname'], $patientFormData['lastname']
        );

        /** @var Patient|null $unchangedPatient */
        $unchangedPatient = null;
        if ($patientId) {
            $unchangedPatient = $this->patientModel->find($patientId);
            if (!$unchangedPatient) {
                throw new GeneralException("Patient with ID $patientId not found");
            }
            if ($patientFormData['email'] != $unchangedPatient->email) {
                $patientFormData['email_bounce'] = 0;
            }
        }

        $responseData = new EditPatientResponseData();
        $this->populateResponseData(
            $responseData,
            $patientId,
            $patientFormData,
            $ip,
            $uniqueLogin,
            $currentUser,
            $hasPatientPortal,
            $patientLocation,
            $emailTypesForSending,
            $pressedButtons,
            $unchangedPatient
        );
        if ($responseData->createdPatientId) {
            $patientId = $responseData->createdPatientId;
        }

        $mdContacts = $this->formMdContacts($patientFormData);
        $params = [
            LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts,
        ];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);

        if (!empty($patientFormData['introletter']) && $patientFormData['introletter'] == 1) {
            $this->letterToPatientTrigger->trigger($patientId, $docId, $userId);
        }

        if ($this->shouldSendRegistrationEmail($hasPatientPortal, $emailTypesForSending)) {
            $this->sendRegistrationEmail(
                $responseData, $patientFormData, $unchangedPatient, $patientId
            );
        }

        $isInfoComplete = $this->patientFormDataChecker->isInfoComplete($patientFormData);

        $this->patientSummaryManager->updatePatientSummary($patientId, $isInfoComplete);
        return $responseData;
    }

    private function populateResponseData(
        EditPatientResponseData $responseData,
        $patientId,
        array $patientFormData,
        $ip,
        $uniqueLogin,
        User $currentUser,
        $hasPatientPortal,
        $patientLocation,
        array $emailTypesForSending,
        $pressedButtons,
        Patient $unchangedPatient = null
    ) {
        if ($patientId) {
            $this->patientUpdater->updatePatient(
                $responseData, $unchangedPatient, $patientFormData, $currentUser, $patientId, $emailTypesForSending, $pressedButtons, $uniqueLogin, $hasPatientPortal, $patientLocation
            );
            return;
        }
        $this->patientCreator->createPatient(
            $responseData, $patientFormData, $currentUser, $ip, $uniqueLogin, $patientLocation
        );
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

    private function shouldSendRegistrationEmail($hasPatientPortal, array $emailTypesForSending)
    {
        if (
            $emailTypesForSending
            &&
            !empty($emailTypesForSending['registration'])
            &&
            $hasPatientPortal
        ) {
            return true;
        }
        return false;
    }

    private function sendRegistrationEmail(
        EditPatientResponseData $responseData,
        array $patientFormData,
        Patient $unchangedPatient,
        $patientId
    ) {
        // TODO: this logic needs to be checked. emails are not sent by phone
        $message = 'Unable to send registration email because no cellphone number is set. Please enter a cellphone number and try again.';
        if ($patientFormData['email'] && $patientFormData['cell_phone']) {
            $oldEmail = '';
            if ($unchangedPatient) {
                $oldEmail = $unchangedPatient->email;
            }
            $this->registrationEmailHandler->handleEmail($patientId, $patientFormData['email'], $oldEmail, true);
            $message = 'The registration mail was successfully sent.';
        }
        $mail = new EditPatientMail();
        $mail->mailType = EmailHandlerFactory::REGISTRATION_MAIL;
        $mail->message = $message;
        $responseData->mails = $mail;
    }
}
