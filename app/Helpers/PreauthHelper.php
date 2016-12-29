<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\SummSleeplab;

class PreauthHelper
{
    private $patient;
    private $summSleeplab;

    public function __construct(Patient $patient, SummSleeplab $summSleeplab)
    {
        $this->patient = $patient;
        $this->summSleeplab = $summSleeplab;
    }

    public function createVob($patientId)
    {
        $e0486 = $this->patient->getDentalDeviceTransactionCode($patientId);
        $userInfo = $this->patient->getUserInfo($patientId);

        if (!$e0486 && !$userInfo) {
            return "e0486_user";
        } elseif(!$e0486) {
            return "e0486";
        } elseif(!$userInfo) {
            return "user";
        }

        $patientPreauthInfo = $this->patient->getInsurancePreauthInfo($patientId);

        $sleepStudy = $this->summSleeplab->getPatientDiagnosis($patientId);

        
    }
}
