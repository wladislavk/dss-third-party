<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Models\Dental\User;

class PendingVOBRemover
{
    /** @var PreauthHelper */
    private $preauthHelper;

    /** @var InsurancePreauth */
    private $insurancePreauthModel;

    public function __construct(
        PreauthHelper $preauthHelper,
        InsurancePreauth $insurancePreauthModel
    ) {
        $this->preauthHelper = $preauthHelper;
        $this->insurancePreauthModel = $insurancePreauthModel;
    }

    /**
     * @param User $currentUser
     * @param int $patientId
     * @param int $userId
     */
    public function removePendingVerificationOfBenefits(User $currentUser, $patientId, $userId)
    {
        $username = '';
        if ($currentUser->name) {
            $username = $currentUser->name;
        }
        $updatedVerificationOfBenefits = $this->insurancePreauthModel->updateVob($patientId, $username);
        if ($updatedVerificationOfBenefits) {
            $insurancePreauthData = $this->preauthHelper
                ->createVerificationOfBenefits($patientId, $userId);
            if ($insurancePreauthData) {
                $this->insurancePreauthModel->create($insurancePreauthData);
            }
        }
    }
}
