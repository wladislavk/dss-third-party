<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummSleeplabRepository;

class PreauthHelper
{
    const DSS_PREAUTH_PENDING = 0;

    /** @var PatientRepository */
    private $patientRepository;

    /** @var SummSleeplabRepository */
    private $summSleeplabRepository;

    public function __construct(
        PatientRepository $patientRepository,
        SummSleeplabRepository $summSleeplabRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->summSleeplabRepository = $summSleeplabRepository;
    }

    /**
     * @param int $patientId
     * @param int $userId
     * @return InsurancePreauth|null
     */
    public function createVerificationOfBenefits($patientId, $userId)
    {
        $transactionCode = $this->patientRepository->getDentalDeviceTransactionCode($patientId);
        $userInfo = $this->patientRepository->getUserInfo($patientId);

        if (!$transactionCode || !$userInfo) {
            return null;
        }

        $patientPreauthInfo = $this->patientRepository->getInsurancePreauthInfo($patientId);
        if (!$patientPreauthInfo) {
            return null;
        }

        $sleepStudy = $this->summSleeplabRepository->getPatientDiagnosis($patientId);
        $diagnosisCode = '';
        if ($sleepStudy) {
            $diagnosisCode = $sleepStudy->diagnosis;
        }

        $patientPreauthInfo = $patientPreauthInfo->toArray();
        $patientPreauthInfo = array_merge($patientPreauthInfo, [
            'patient_id'                => $patientId,
            'diagnosis_code'            => $diagnosisCode,
            'front_office_request_date' => Carbon::now(),
            'status'                    => self::DSS_PREAUTH_PENDING,
            'userid'                    => $userId,
            'viewed'                    => 1,
        ]);

        $newInsurancePreauth = new InsurancePreauth($patientPreauthInfo);
        return $newInsurancePreauth;
    }
}
