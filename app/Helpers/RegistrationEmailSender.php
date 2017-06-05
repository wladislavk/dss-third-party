<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;

class RegistrationEmailSender
{
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
        $message = 'Unable to send registration email because no cellphone number is set. Please enter a cellphone number and try again.';
        if ($requestData->newEmail && $requestData->cellphone) {
            $oldEmail = $this->getOldEmail($unchangedPatient);
            $patientId = $this->getPatientId($unchangedPatient);
            $this->registrationEmailHandler->handleEmail(
                $patientId, $requestData->newEmail, $oldEmail, true
            );
            $message = 'The registration mail was successfully sent.';
        }
        $mail = new EditPatientMail();
        $mail->mailType = EmailHandlerFactory::REGISTRATION_MAIL;
        $mail->message = $message;
        $responseData->mails = $mail;
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
