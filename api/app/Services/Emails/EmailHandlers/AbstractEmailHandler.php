<?php

namespace DentalSleepSolutions\Services\Emails\EmailHandlers;

use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Services\Emails\EmailSender;
use DentalSleepSolutions\Services\Emails\MailerDataRetriever;
use DentalSleepSolutions\Structs\RequestedEmails;

abstract class AbstractEmailHandler
{
    const UNREGISTERED_STATUS = 0;
    const REGISTRATION_EMAILED_STATUS = 1;
    const REGISTERED_STATUS = 2;

    /** @var MailerDataRetriever */
    private $mailerDataRetriever;

    /** @var EmailSender */
    private $emailSender;

    public function __construct(MailerDataRetriever $mailerDataRetriever, EmailSender $emailSender)
    {
        $this->mailerDataRetriever = $mailerDataRetriever;
        $this->emailSender = $emailSender;
    }

    /**
     * @param int $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param bool $hasPatientPortal
     * @return void
     * @throws EmailHandlerException
     */
    public function handleEmail($patientId, $newEmail, $oldEmail = '', $hasPatientPortal = false)
    {
        if (!$this->shouldBeSent($newEmail, $oldEmail, $hasPatientPortal)) {
            return;
        }
        $patientId = (int)$patientId;
        $contactData = $this->mailerDataRetriever->retrieveMailerData($patientId);

        $patientData = $contactData->patientData->toArray();
        $mailingData = $contactData->mailingData->toArray();

        $newPatientData = $this->extendPatientData($patientId, $newEmail, $oldEmail, $patientData);
        $mailingData = $this->modifyMailingData(
            $mailingData, $patientId, $newEmail, $oldEmail, $newPatientData
        );
        $this->updateModels($patientId, $newPatientData);

        $addresses = $this->getAddresses($newEmail, $oldEmail);
        foreach ($addresses as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->emailSender->sendEmail(
                    $mailingData,
                    $email,
                    $patientData['firstname'],
                    $patientData['lastname'],
                    $this->getEmailSubject(),
                    $this->getEmailView()
                );
            }
        }
    }

    /**
     * @param RequestedEmails $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return bool
     */
    abstract public function isCorrectType(
        RequestedEmails $emailTypesForSending,
        $registrationStatus,
        $newEmail,
        $oldEmail
    );

    /**
     * @param array $mailingData
     * @param int $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param array $newPatientData
     * @return array
     */
    private function modifyMailingData(
        array $mailingData,
        $patientId,
        $newEmail,
        $oldEmail,
        array $newPatientData
    ) {
        $mailingData['email'] = $newEmail;
        $mailingData['old_email'] = $oldEmail;
        $mailingData['new_email'] = $newEmail;
        $link = $this->getLink($patientId, $newEmail, $newPatientData);
        if ($link !== null) {
            $mailingData['link'] = $link;
        }
        $legend = $this->getLegend();
        if ($legend !== null) {
            $mailingData['legend'] = $legend;
        }
        return $mailingData;
    }

    /**
     * @return string
     */
    abstract public function getMessage();

    /**
     * @param int $patientId
     * @param array $newPatientData
     * @return void
     */
    abstract protected function updateModels($patientId, array $newPatientData);

    /**
     * @return string
     */
    abstract protected function getEmailSubject();

    /**
     * @return string
     */
    abstract protected function getEmailView();

    /**
     * @param string $newEmail
     * @param string $oldEmail
     * @param bool $hasPatientPortal
     * @return bool
     */
    abstract protected function shouldBeSent($newEmail, $oldEmail, $hasPatientPortal);

    /**
     * @return string|null
     */
    abstract protected function getLegend();

    /**
     * @param int $id
     * @param string $email
     * @param array $patientData
     * @return string|null
     */
    abstract protected function getLink($id, $email, array $patientData);

    /**
     * @param string $newEmail
     * @param string $oldEmail
     * @return array
     */
    abstract protected function getAddresses($newEmail, $oldEmail);

    /**
     * @param int $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param array $patientData
     * @return mixed
     */
    abstract protected function extendPatientData($patientId, $newEmail, $oldEmail, array $patientData);
}
