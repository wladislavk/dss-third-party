<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\SummSleeplab;
use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;
use Carbon\Carbon;

class PreauthHelper
{
    const DSS_PREAUTH_PENDING = 0;

    private $patient;
    private $summSleeplab;
    private $insurancePreauth;

    public function __construct(
        Patient $patient,
        SummSleeplab $summSleeplab,
        InsurancePreauth $insurancePreauth
    ) {
        $this->patient = $patient;
        $this->summSleeplab = $summSleeplab;
        $this->insurancePreauth = $insurancePreauth;
    }

    public function createVob($patientId, $userId)
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

        if (!$patientPreauthInfo) {
            return;
        } else {
            $patientPreauthInfo = $patientPreauthInfo->toArray();
        }

        $patientPreauthInfo = array_merge($patientPreauthInfo, [
            'patient_id'                => $patientId,
            'diagnosis_code'            => $sleepStudy ? $sleepStudy->diagnosis : '',
            'front_office_request_date' => Carbon::now(),
            'status'                    => self::DSS_PREAUTH_PENDING,
            'userid'                    => $userId,
            'viewed'                    => 1
        ]);

        $this->insurancePreauth->create($patientPreauthInfo);
    }
}
