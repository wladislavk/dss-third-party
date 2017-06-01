<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Libraries\Password;
use DentalSleepSolutions\Structs\NewPatientFormData;

class PasswordGenerator
{
    /**
     * @param string $ssn
     * @param NewPatientFormData $formData
     */
    public function generatePassword($ssn, NewPatientFormData $formData)
    {
        $formData->salt = Password::createSalt();
        $basePassword = preg_replace('/\D/', '', $ssn);
        $formData->password = Password::genPassword($basePassword, $formData->salt);
    }
}
