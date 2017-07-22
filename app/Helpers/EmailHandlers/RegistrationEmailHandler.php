<?php

namespace DentalSleepSolutions\Helpers\EmailHandlers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\EmailSender;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use DentalSleepSolutions\Helpers\PasswordResetDataSetter;

class RegistrationEmailHandler extends AbstractRegistrationRelatedEmailHandler
{
    const HEAR_FROM_YOU_LEGEND = '<p>We hope to hear from you soon!</p>';

    // TODO: do these pages still exist? if so, all references to them should have their own namespace
    const ACTIVATE_PAGE = 'reg/activate.php';

    const RECOVER_HASH = 'recover_hash';

    /** @var int */
    private $accessType = 1;

    /** @var PasswordResetDataSetter */
    private $passwordResetDataSetter;

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(
        MailerDataRetriever $mailerDataRetriever,
        EmailSender $emailSender,
        PasswordResetDataSetter $passwordResetDataSetter,
        PatientRepository $patientRepository
    ) {
        parent::__construct($mailerDataRetriever, $emailSender);
        $this->passwordResetDataSetter = $passwordResetDataSetter;
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param int $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param array $patientData
     * @return array
     */
    protected function extendPatientData($patientId, $newEmail, $oldEmail, array $patientData)
    {
        $isEmailChanged = false;
        if ($newEmail != $oldEmail) {
            $isEmailChanged = true;
        }
        $newPatientData = $this->passwordResetDataSetter->setPasswordResetData(
            $patientId, $newEmail, $this->accessType, $patientData[self::RECOVER_HASH], $isEmailChanged
        );
        return $newPatientData;
    }

    /**
     * @param int $patientId
     * @param array $newPatientData
     */
    protected function updateModels($patientId, array $newPatientData)
    {
        $this->patientRepository->updatePatient($patientId, $newPatientData);
    }

    /**
     * @return string|null
     */
    protected function getLegend()
    {
        return self::HEAR_FROM_YOU_LEGEND;
    }

    /**
     * @param int $id
     * @param string $email
     * @param array $patientData
     * @return string|null
     */
    protected function getLink($id, $email, array $patientData)
    {
        return self::ACTIVATE_PAGE . "?id=$id&amp;hash={$patientData[self::RECOVER_HASH]}";
    }

    /**
     * @param array $contactData
     * @throws EmailHandlerException
     */
    protected function verifyContactData(array $contactData)
    {
        parent::verifyContactData($contactData);
        if (!isset($contactData['patientData'][self::RECOVER_HASH])) {
            throw new EmailHandlerException('Mailer data is malformed');
        }
    }

    /**
     * @param int $accessType
     */
    public function setAccessType($accessType)
    {
        $this->accessType = $accessType;
    }
}
