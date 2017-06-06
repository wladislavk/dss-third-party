<?php

namespace DentalSleepSolutions\Helpers;

class PatientFormDataChecker
{
    const MANDATORY_KEYS = [
        'add1',
        'city',
        'state',
        'zip',
        'dob',
        'gender',
    ];

    const PHONE_KEYS = [
        'home_phone',
        'work_phone',
        'cell_phone',
    ];

    /**
     * @param array $patientFormData
     * @return bool
     */
    public function isInfoComplete(array $patientFormData)
    {
        if (
            (isset($patientFormData['email']) || $this->hasPatientPhone($patientFormData))
            &&
            $this->checkMandatoryKeys($patientFormData)
        ) {
            return true;
        }
        return false;
    }

    /**
     * @param array $formData
     * @return bool
     */
    private function checkMandatoryKeys(array $formData)
    {
        foreach (self::MANDATORY_KEYS as $key) {
            if (!isset($formData[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $patientFormData
     * @return bool
     */
    private function hasPatientPhone(array $patientFormData)
    {
        foreach (self::PHONE_KEYS as $key) {
            if (isset($patientFormData[$key])) {
                return true;
            }
        }
        return false;
    }
}
