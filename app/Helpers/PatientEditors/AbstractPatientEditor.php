<?php

namespace DentalSleepSolutions\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\LetterTriggerLauncher;
use DentalSleepSolutions\Helpers\PatientFormDataChecker;
use DentalSleepSolutions\Helpers\PatientPortalRetriever;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\RequestedEmails;

abstract class AbstractPatientEditor
{
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
    protected $patientModel;

    public function __construct(
        RegistrationEmailHandler $registrationEmailHandler,
        PatientFormDataChecker $patientFormDataChecker,
        PatientSummaryManager $patientSummaryManager,
        PatientPortalRetriever $patientPortalRetriever,
        LetterTriggerLauncher $letterTriggerLauncher,
        Patient $patientModel
    ) {
        $this->registrationEmailHandler = $registrationEmailHandler;
        $this->patientFormDataChecker = $patientFormDataChecker;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->patientPortalRetriever = $patientPortalRetriever;
        $this->letterTriggerLauncher = $letterTriggerLauncher;
        $this->patientModel = $patientModel;
    }

    public function doActionsAfterDBUpdate()
    {
        $docId = $currentUser->getDocIdOrZero();
        $userType = $currentUser->getUserTypeOrZero();
        $userId = $currentUser->getUserIdOrZero();
        $this->letterTriggerLauncher->triggerLetters(
            $patientId, $docId, $userId, $userType, $shouldSendIntroLetter, $mdContacts
        );
    }

    public function modifyResponseData(EditPatientResponseData $responseData)
    {
        if ($this->shouldSendRegistrationEmail($hasPatientPortal, $emailTypesForSending)) {
            $this->sendRegistrationEmail(
                $responseData, $patientFormData, $unchangedPatient, $patientId
            );
        }
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

    public function updateDB(array $formData)
    {
        $newFormData = $this->getNewFormData();
        $updatedFormData = array_merge($formData, $newFormData->toArray());
        $entity = $this->launchDBUpdatingMethods($updatedFormData);
        return $entity;
    }

    /**
     * @return NewPatientFormData
     */
    abstract protected function getNewFormData();

    abstract protected function launchDBUpdatingMethods(array $formData);

}
