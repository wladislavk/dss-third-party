<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Factories\EmailHandlerFactory;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Structs\EditPatientMail;

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
     * @param int $patientId
     * @param array $emailTypesForSending
     * @param bool $hasPatientPortal
     * @return EditPatientMail
     */
    public function handleEmails(
        Patient $unchangedPatient,
        $newEmail,
        $patientId,
        array $emailTypesForSending,
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
        $handler->handleEmail($patientId, $newEmail, $oldEmail, $hasPatientPortal);
        $message = $handler->getMessage();
        $editPatientMail->mailType = $mailType;
        $editPatientMail->message = $message;
        return $editPatientMail;
    }

    /**
     * @param array $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return null|string
     */
    private function getMailType(array $emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)
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
     * @param array $emailTypesForSending
     * @return bool
     */
    private function isReminder(array $emailTypesForSending)
    {
        if (!empty($emailTypesForSending['reminder'])) {
            return true;
        }
        return false;
    }

    /**
     * @param array $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return bool
     */
    private function isRegistration(array $emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)
    {
        if (!empty($emailTypesForSending['registration'])) {
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
