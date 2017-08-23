<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Http\Controllers\InsurancesController;

class UnmailedClaimsRetriever
{
    /** @var InsuranceRepository */
    private $insuranceRepository;

    public function __construct(InsuranceRepository $insuranceRepository)
    {
        $this->insuranceRepository = $insuranceRepository;
    }

    /**
     * @param int $docId
     * @param int $userType
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUnmailedClaims($docId, $userType)
    {
        if ($userType == InsurancesController::DSS_USER_TYPE_SOFTWARE) {
            return $this->insuranceRepository->getUnmailedClaimsForSoftware($docId);
        }

        return $this->insuranceRepository->getUnmailedClaims($docId);
    }
}
