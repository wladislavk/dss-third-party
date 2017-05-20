<?php

namespace DentalSleepSolutions\Helpers;

use Carbon\Carbon;

class PasswordResetDataSetter
{
    /**
     * @param int $patientId
     * @param string $email
     * @param int $accessType
     * @param string $hash
     * @param bool $isEmailChanged
     * @return array
     */
    public function setPasswordResetData($patientId, $email, $accessType, $hash, $isEmailChanged)
    {
        $newPatientData = [
            'access_type' => $accessType,
            'registration_status' => 1,
            'registration_senton' => Carbon::now(),
            'recover_hash' => $hash,
        ];
        if ($hash == '' || $isEmailChanged) {
            $accessCode = $this->getAccessCode();
            $newHash = $this->getRecoverHash($patientId, $email);

            $additionalPatientData = [
                'text_num'            => 0,
                'access_code'         => $accessCode,
                'recover_hash'        => $newHash,
                'text_date'           => Carbon::now(),
                'recover_time'        => Carbon::now(),
            ];
            $newPatientData = array_merge($newPatientData, $additionalPatientData);
        }
        return $newPatientData;
    }

    /**
     * @return string
     */
    private function getAccessCode()
    {
        return '' . rand(100000, 999999);
    }

    /**
     * @param int $patientId
     * @param string $email
     * @return string
     */
    private function getRecoverHash($patientId, $email)
    {
        $recoverHash = hash('sha256', $patientId . $email . rand());
        return $recoverHash;
    }
}
