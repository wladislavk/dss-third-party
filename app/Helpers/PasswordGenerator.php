<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\NewPatientFormData;

class PasswordGenerator
{
    /**
     * @param string $ssn
     * @param NewPatientFormData $formData
     */
    public function generatePassword($ssn, NewPatientFormData $formData)
    {
        $formData->salt = $this->createSalt();
        $basePassword = preg_replace('/\D/', '', $ssn);
        $formData->password = $this->genPassword($basePassword, $formData->salt);
    }

// TODO: IMPORTANT! these functions might not be cryptographically secure!
// TODO: it is highly advisable to switch to native Laravel security methods
    /**
     * @return string
     */
    private function createSalt()
    {
        $salt = substr(sha1(uniqid(rand(), true)), 0, 12);
        return $salt;
    }

    /**
     * @param string $password
     * @param string $salt
     * @return string
     */
    private function genPassword($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }
}
