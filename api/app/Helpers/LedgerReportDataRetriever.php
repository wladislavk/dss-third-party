<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsuranceRepository;
use DentalSleepSolutions\Helpers\QueryComposers\LedgersQueryComposer;
use DentalSleepSolutions\Structs\LedgerReportData;
use Illuminate\Database\Eloquent\Collection;

class LedgerReportDataRetriever
{
    /** @var LedgersQueryComposer */
    private $ledgersQueryComposer;

    /** @var InsuranceRepository */
    private $insuranceRepository;

    public function __construct(LedgersQueryComposer $ledgersQueryComposer, InsuranceRepository $insuranceRepository)
    {
        $this->ledgersQueryComposer = $ledgersQueryComposer;
        $this->insuranceRepository = $insuranceRepository;
    }

    /**
     * @param LedgerReportData $ledgerReportData
     * @param bool $openClaims
     * @return array|Collection
     */
    public function getReportData(LedgerReportData $ledgerReportData, $openClaims)
    {
        if ($openClaims) {
            return $this->insuranceRepository->getOpenClaims($ledgerReportData);
        }

        return $this->ledgersQueryComposer->getReportData($ledgerReportData);
    }
}
