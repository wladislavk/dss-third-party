<?php

namespace DentalSleepSolutions\Helpers\EmailHandlers;

class UpdateEmailHandler extends AbstractEmailHandler
{
    const MESSAGE = 'The mail about changing patient email was successfully sent.';

    const EMAIL_SUBJECT = 'Online Patient Portal Email Update';
    const EMAIL_VIEW = 'emails.update';

    const UPDATED_BY_OTHER_LEGEND = 'An update has been made to your account.';

    /**
     * @return string
     */
    protected function getEmailSubject()
    {
        return self::EMAIL_SUBJECT;
    }

    /**
     * @return string
     */
    protected function getEmailView()
    {
        return self::EMAIL_VIEW;
    }

    /**
     * @param string $newEmail
     * @param string $oldEmail
     * @param bool $hasPatientPortal
     * @return bool
     */
    protected function shouldBeSent($newEmail, $oldEmail, $hasPatientPortal)
    {
        if (strtolower(trim($oldEmail)) === strtolower(trim($newEmail))) {
            return false;
        }
        return true;
    }

    /**
     * @return string|null
     */
    protected function getLegend()
    {
        return self::UPDATED_BY_OTHER_LEGEND;
    }

    /**
     * @param int $id
     * @param string $email
     * @param array $patientData
     * @return string|null
     */
    protected function getLink($id, $email, array $patientData)
    {
        return null;
    }

    /**
     * @param string $newEmail
     * @param string $oldEmail
     * @return array
     */
    protected function getAddresses($newEmail, $oldEmail)
    {
        return [$newEmail, $oldEmail];
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
        return [];
    }

    /**
     * @param int $patientId
     * @param array $newPatientData
     */
    protected function updateModels($patientId, array $newPatientData)
    {
        // do nothing
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return self::MESSAGE;
    }
}
