<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;

class RegistrationEmailSender
{
    const FAILURE_MESSAGE = 'Unable to send registration email because no cellphone number is set. Please enter a cellphone number and try again.';
    const SUCCESS_MESSAGE = 'The registration mail was successfully sent.';

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    public function __construct(RegistrationEmailHandler $registrationEmailHandler)
    {
        $this->registrationEmailHandler = $registrationEmailHandler;
    }

    /**
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    public function sendRegistrationEmail(
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        // TODO: this logic needs to be checked. emails are not sent by phone
        if (!$this->shouldSend($requestData)) {
            return;
        }
        $message = self::FAILURE_MESSAGE;
        if ($requestData->newEmail && $requestData->cellphone) {
            $oldEmail = $this->getOldEmail($unchangedPatient);
            $patientId = $this->getPatientId($unchangedPatient);
            $this->registrationEmailHandler->handleEmail(
                $patientId, $requestData->newEmail, $oldEmail, true
            );
            $message = self::SUCCESS_MESSAGE;
        }
        $mail = new EditPatientMail();
        $mail->mailType = EmailHandlerFactory::REGISTRATION_MAIL;
        $mail->message = $message;
        $responseData->mails = $mail;
    }

    /**
     * @param EditPatientRequestData $requestData
     * @return bool
     */
    private function shouldSend(EditPatientRequestData $requestData)
    {
        if (!$requestData->requestedEmails->registration) {
            return false;
        }
        if (!$requestData->hasPatientPortal) {
            return false;
        }
        return true;
    }

    /**
     * @param Patient|null $unchangedPatient
     * @return int
     */
    private function getPatientId(Patient $unchangedPatient = null)
    {
        if ($unchangedPatient) {
            return $unchangedPatient->patientid;
        }
        return 0;
    }

    /**
     * @param Patient|null $unchangedPatient
     * @return string
     */
    private function getOldEmail(Patient $unchangedPatient = null)
    {
        if ($unchangedPatient) {
            return $unchangedPatient->email;
        }
        return '';
    }
}
