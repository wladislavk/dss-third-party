<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\RequestedEmails;

class PatientUpdateMailer
{
    const UNREGISTERED_STATUS = 0;
    const REGISTRATION_EMAILED_STATUS = 1;
    const REGISTERED_STATUS = 2;

    /** @var UpdateEmailHandler */
    private $emailHandlerFactory;

    public function __construct(EmailHandlerFactory $emailHandlerFactory)
    {
        $this->emailHandlerFactory = $emailHandlerFactory;
    }

    /**
     * @param Patient $unchangedPatient
     * @param string $newEmail
     * @param RequestedEmails $emailTypesForSending
     * @param bool $hasPatientPortal
     * @return EditPatientMail
     */
    public function handleEmails(
        Patient $unchangedPatient,
        $newEmail,
        RequestedEmails $emailTypesForSending,
        $hasPatientPortal
    ) {
        $editPatientMail = new EditPatientMail();
        $oldEmail = $unchangedPatient->email;
        $registrationStatus = $unchangedPatient->registration_status;
        $mailType = $this->getMailType($emailTypesForSending, $registrationStatus, $newEmail, $oldEmail);
        if (!$mailType) {
            // TODO: check if exception should be thrown
            return $editPatientMail;
        }
        $handler = $this->emailHandlerFactory->getEmailHandler($mailType);
        $handler->handleEmail($unchangedPatient->patientid, $newEmail, $oldEmail, $hasPatientPortal);
        $message = $handler->getMessage();
        $editPatientMail->mailType = $mailType;
        $editPatientMail->message = $message;
        return $editPatientMail;
    }

    /**
     * @param RequestedEmails $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return null|string
     */
    private function getMailType(RequestedEmails $emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)
    {
        if ($this->isUpdate($registrationStatus, $newEmail, $oldEmail)) {
            return EmailHandlerFactory::UPDATED_MAIL;
        }
        if ($this->isReminder($emailTypesForSending)) {
            return EmailHandlerFactory::REMINDER_MAIL;
        }
        if ($this->isRegistration($emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)) {
            return EmailHandlerFactory::REGISTRATION_MAIL;
        }
        return null;
    }

    /**
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return bool
     */
    private function isUpdate($registrationStatus, $newEmail, $oldEmail)
    {
        if ($registrationStatus != self::REGISTERED_STATUS) {
            return false;
        }
        if ($newEmail == $oldEmail) {
            return false;
        }
        return true;
    }

    /**
     * @param RequestedEmails $emailTypesForSending
     * @return bool
     */
    private function isReminder(RequestedEmails $emailTypesForSending)
    {
        if ($emailTypesForSending->reminder) {
            return true;
        }
        return false;
    }

    /**
     * @param RequestedEmails $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return bool
     */
    private function isRegistration(RequestedEmails $emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)
    {
        if ($emailTypesForSending->registration) {
            return false;
        }
        if ($registrationStatus != self::REGISTRATION_EMAILED_STATUS) {
            return false;
        }
        if ($newEmail == $oldEmail) {
            return false;
        }
        return true;
    }
}
