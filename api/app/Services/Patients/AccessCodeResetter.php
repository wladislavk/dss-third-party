<?php

namespace DentalSleepSolutions\Services\Patients;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;

class AccessCodeResetter
{
    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
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
        $this->patientRepository->updatePatient($patientId, $updateData);
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
