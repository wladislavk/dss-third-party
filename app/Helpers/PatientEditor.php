<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\MDContacts;
use DentalSleepSolutions\Structs\PatientName;
use DentalSleepSolutions\Structs\PressedButtons;
use DentalSleepSolutions\Structs\RequestedEmails;

class PatientEditor
{
    /** @var PatientCreator */
    private $patientCreator;

    /** @var PatientUpdater */
    private $patientUpdater;

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    /** @var PatientFormDataChecker */
    private $patientFormDataChecker;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var PatientPortalRetriever */
    private $patientPortalRetriever;

    /** @var LetterTriggerLauncher */
    private $letterTriggerLauncher;

    /** @var Patient */
    private $patientModel;

    public function __construct(
        PatientCreator $patientCreator,
        PatientUpdater $patientUpdater,
        RegistrationEmailHandler $registrationEmailHandler,
        PatientFormDataChecker $patientFormDataChecker,
        PatientSummaryManager $patientSummaryManager,
        PatientPortalRetriever $patientPortalRetriever,
        LetterTriggerLauncher $letterTriggerLauncher,
        Patient $patientModel
    ) {
        $this->patientCreator = $patientCreator;
        $this->patientUpdater = $patientUpdater;
        $this->registrationEmailHandler = $registrationEmailHandler;
        $this->patientFormDataChecker = $patientFormDataChecker;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->patientPortalRetriever = $patientPortalRetriever;
        $this->letterTriggerLauncher = $letterTriggerLauncher;
        $this->patientModel = $patientModel;
    }

    public function editPatient(
        User $currentUser,
        RequestedEmails $emailTypesForSending,
        PressedButtons $pressedButtons,
        array $patientFormData,
        $patientLocation,
        $hasPatientPortal,
        $shouldSendIntroLetter,
        PatientName $patientName,
        MDContacts $mdContacts,
        Patient $unchangedPatient = null
    ) {
        $docId = $currentUser->getDocIdOrZero();
        $userType = $currentUser->getUserTypeOrZero();
        $userId = $currentUser->getUserIdOrZero();

        // TODO: need to add logic for logging actions

        $responseData = new EditPatientResponseData();
        $this->populateResponseData(
            $responseData,
            $patientFormData,
            $currentUser,
            $hasPatientPortal,
            $patientLocation,
            $emailTypesForSending,
            $pressedButtons,
            $patientName,
            $unchangedPatient
        );
        $patientId = $unchangedPatient->patientid;
        if ($responseData->createdPatientId) {
            $patientId = $responseData->createdPatientId;
        }

        $this->letterTriggerLauncher->triggerLetters(
            $patientId, $docId, $userId, $userType, $shouldSendIntroLetter, $mdContacts
        );

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
        array $patientFormData,
        User $currentUser,
        $hasPatientPortal,
        $patientLocation,
        RequestedEmails $emailTypesForSending,
        PressedButtons $pressedButtons,
        PatientName $patientName,
        Patient $unchangedPatient = null
    ) {
        if ($unchangedPatient) {
            $this->patientUpdater->updatePatient(
                $responseData,
                $unchangedPatient,
                $patientFormData,
                $currentUser,
                $emailTypesForSending,
                $pressedButtons,
                $hasPatientPortal,
                $patientLocation
            );
            return;
        }
        $this->patientCreator->createPatient(
            $responseData,
            $patientFormData,
            $currentUser,
            $patientLocation,
            $patientName
        );
    }

    private function shouldSendRegistrationEmail($hasPatientPortal, RequestedEmails $emailTypesForSending)
    {
        if ($emailTypesForSending->registration && $hasPatientPortal) {
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
