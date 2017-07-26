<?php

namespace DentalSleepSolutions\Helpers\EmailHandlers;

use DentalSleepSolutions\Structs\RequestedEmails;

class RememberEmailHandler extends AbstractRegistrationRelatedEmailHandler
{
    const MESSAGE = 'The reminding mail was successfully sent.';

    // TODO: do these pages still exist? if so, all references to them should have their own namespace
    const LOGIN_PAGE = 'reg/login.php';

    /**
     * @param RequestedEmails $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return bool
     */
    public function isCorrectType(
        RequestedEmails $emailTypesForSending,
        $registrationStatus,
        $newEmail,
        $oldEmail
    ) {
        if ($emailTypesForSending->reminder) {
            return true;
        }
        return false;
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
     * @return string|null
     */
    protected function getLegend()
    {
        return null;
    }

    /**
     * @param int $id
     * @param string $email
     * @param array $patientData
     * @return string|null
     */
    protected function getLink($id, $email, array $patientData)
    {
        return self::LOGIN_PAGE . '?email=' . $email;
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
     * @param string $newEmail
     * @param string $oldEmail
     * @param bool $hasPatientPortal
     * @return bool
     */
    protected function shouldBeSent($newEmail, $oldEmail, $hasPatientPortal)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return self::MESSAGE;
    }
}
