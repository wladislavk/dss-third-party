<?php

namespace DentalSleepSolutions\Helpers;

class EmailHelper
{
    public function __construct()
    {

    }

    /**
     * @param int    $patientId
     * @param string $newEmail
     * @param string $oldEmail
     * @param string $sentBy
     *
     * @return bool
     */
    public function sendUpdatedEmail($patientId, $newEmail, $oldEmail, $sentBy)
    {

    }

    /**
     * Send "remember" email
     *
     * @param int    $patientId
     * @param string $patientEmail
     *
     * @return bool
     */
    public function sendRemEmail($patientId, $patientEmail)
    {
        return $this->sendRegistrationRelatedEmail($patientId, $patientEmail, false);
    }

    /**
     * Send registration email
     *
     * @param int    $patientId
     * @param string $patientEmail
     * @param mixed  $unusedLogin
     * @param string $oldEmail
     * @param int    $accessType
     * @return bool
     */
    public function sendRegEmail($patientId, $patientEmail, $unusedLogin, $oldEmail, $accessType = 1)
    {
        return $this->sendRegistrationRelatedEmail($patientId, $patientEmail, true, $oldEmail, $accessType);
    }

    /**
     * @param int    $patientId
     * @param string $patientEmail
     * @param bool   $isPasswordReset
     * @param string $oldEmail
     * @param int    $accessType
     *
     * @return bool
     */
    private function sendRegistrationRelatedEmail($patientId, $patientEmail, $isPasswordReset = false, $oldEmail = '', $accessType = 1)
    {

    }
}
