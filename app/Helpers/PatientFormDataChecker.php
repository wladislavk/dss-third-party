<?php

namespace DentalSleepSolutions\Helpers;

class PatientFormDataChecker
{
    /**
     * @param array $patientFormData
     * @return bool
     */
    public function isInfoComplete(array $patientFormData)
    {
        $patientEmail = false;
        if (!empty($patientFormData['email'])) {
            $patientEmail = true;
        }
        if (
            ($patientEmail || $this->hasPatientPhone($patientFormData))
            &&
            !empty($patientFormData['add1'])
            &&
            !empty($patientFormData['city'])
            &&
            !empty($patientFormData['state'])
            &&
            !empty($patientFormData['zip'])
            &&
            !empty($patientFormData['dob'])
            &&
            !empty($patientFormData['gender'])
        ) {
            return true;
        }
        return false;
    }

    /**
     * @param array $patientFormData
     * @return bool
     */
    private function hasPatientPhone(array $patientFormData)
    {
        if (
            !empty($patientFormData['home_phone'])
            ||
            !empty($patientFormData['work_phone'])
            ||
            !empty($patientFormData['cell_phone'])
        ) {
            return true;
        }
        return false;
    }
}
