<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;

class UniqueLoginGenerator
{
    /** @var Patient */
    private $patientModel;

    public function __construct(Patient $patientModel)
    {
        $this->patientModel = $patientModel;
    }

    public function generateUniquePatientLogin(array $patientFormData)
    {
        $uniqueLogin = strtolower(
            substr($patientFormData["firstname"], 0, 1) . $patientFormData["lastname"]
        );

        $similarPatientLogin = $this->patientModel->getSimilarPatientLogin($uniqueLogin);

        if ($similarPatientLogin) {
            $number = str_replace($uniqueLogin, '', $similarPatientLogin->login);
            $number = $number + 1;
            $uniqueLogin = $uniqueLogin . $number;
        }
        return $uniqueLogin;
    }
}
