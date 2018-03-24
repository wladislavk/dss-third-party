<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Http\Controllers\InsurancesController;

class PendingClaimRemover
{
    /** @var InsuranceRepository */
    private $insuranceRepository;

    /** @var LedgerRepository */
    private $ledgerRepository;

    public function __construct(InsuranceRepository $insuranceRepository, LedgerRepository $ledgerRepository)
    {
        $this->insuranceRepository = $insuranceRepository;
        $this->ledgerRepository = $ledgerRepository;
    }

    /**
     * @param int $claimId
     * @throws GeneralException
     */
    public function removePendingClaim($claimId)
    {
        $isSuccess = $this->insuranceRepository->removePendingClaim($claimId);

        if (!$isSuccess) {
            throw new GeneralException('Could not remove pending claim');
        }

        $this->ledgerRepository->updateWherePrimaryClaimId($claimId, [
            'primary_claim_id' => null,
            'status' => InsurancesController::DSS_TRXN_NA,
        ]);
    }
}
