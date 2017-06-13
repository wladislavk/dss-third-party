<?php

namespace DentalSleepSolutions\Helpers\EmailHandlers;

use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\EmailSender;
use DentalSleepSolutions\Helpers\MailerDataRetriever;

abstract class AbstractEmailHandler
{
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
     *
     * @return void
     */
    public function handleEmail($patientId, $newEmail, $oldEmail = '')
    {
        if (!$this->shouldBeSent($newEmail, $oldEmail)) {
            return;
        }
        $patientId = intval($patientId);
        $contactData = $this->mailerDataRetriever->retrieveMailerData($patientId);
        $this->verifyContactData($contactData);

        $patientData = $contactData['patientData'];
        $mailingData = $contactData['mailingData'];

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
     * @param array $contactData
     * @throws EmailHandlerException
     */
    protected function verifyContactData(array $contactData)
    {
        if (
            !isset($contactData['patientData'])
            ||
            !isset($contactData['mailingData'])
            ||
            !isset($contactData['patientData']['firstname'])
            ||
            !isset($contactData['patientData']['lastname'])
        ) {
            throw new EmailHandlerException('Mailer data is malformed');
        }
    }

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
     * @return bool
     */
    abstract protected function shouldBeSent($newEmail, $oldEmail);

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
