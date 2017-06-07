<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Dental\Patient;

class AccessCodeResetter
{
    /** @var Patient */
    private $patientModel;

    public function __construct(Patient $patientModel)
    {
        $this->patientModel = $patientModel;
    }

    public function resetAccessCode($patientId)
    {
        $updateData = [
            'access_code' => 0,
            'access_code_date' => null,
        ];
        if (!$patientId) {
            return $updateData;
        }
        $accessCode = $this->generateAccessCode();
        $accessCodeDate = Carbon::now();
        $updateData['access_code'] = $accessCode;
        $updateData['access_code_date'] = $accessCodeDate;
        $this->patientModel->updatePatient($patientId, $updateData);
        $updateData['access_code_date'] = $accessCodeDate->toDateTimeString();
        return $updateData;
    }

    /**
     * @return int
     */
    private function generateAccessCode()
    {
        return rand(100000, 999999);
    }
}
