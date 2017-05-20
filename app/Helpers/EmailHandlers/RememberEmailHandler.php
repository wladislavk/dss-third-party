<?php

namespace DentalSleepSolutions\Helpers\EmailHandlers;

class RememberEmailHandler extends AbstractRegistrationRelatedEmailHandler
{
    // TODO: do these pages still exist? if so, all references to them should have their own namespace
    const LOGIN_PAGE = 'reg/login.php';

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
}
