<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\SummSleeplab;
use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;

class PreauthHelper
{
    const DSS_PREAUTH_PENDING = 0;

    /** @var Patient */
    private $patientModel;

    /** @var SummSleeplab */
    private $summSleeplabModel;

    public function __construct(
        Patient $patientModel,
        SummSleeplab $summSleeplabModel
    ) {
        $this->patientModel = $patientModel;
        $this->summSleeplabModel = $summSleeplabModel;
    }

    /**
     * @param int $patientId
     * @param int $userId
     * @return InsurancePreauth|null
     */
    public function createVerificationOfBenefits($patientId, $userId)
    {
        $transactionCode = $this->patientModel->getDentalDeviceTransactionCode($patientId);
        $userInfo = $this->patientModel->getUserInfo($patientId);

        if (!$transactionCode || !$userInfo) {
            return null;
        }

        $patientPreauthInfo = $this->patientModel->getInsurancePreauthInfo($patientId);
        if (!$patientPreauthInfo) {
            return null;
        }

        $sleepStudy = $this->summSleeplabModel->getPatientDiagnosis($patientId);
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
