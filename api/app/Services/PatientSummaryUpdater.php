<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;

class PatientSummaryUpdater
{
    const CREATED = 'Patient Summary was successfully inserted.';
    const UPDATED = 'Patient Summary was successfully updated.';

    /** @var LedgerRepository */
    private $ledgerRepository;

    /** @var PatientSummaryRepository */
    private $patientSummaryRepository;

    public function __construct(
        LedgerRepository $ledgerRepository,
        PatientSummaryRepository $patientSummaryRepository
    ) {
        $this->ledgerRepository = $ledgerRepository;
        $this->patientSummaryRepository = $patientSummaryRepository;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return string
     */
    public function updatePatientSummary($docId, $patientId)
    {
        $patientSummary = $this->patientSummaryRepository->getPatientInfo($patientId);

        if ($patientSummary) {
            $ledgerBalance = $this->modifyLedgerBalance($docId, $patientId);

            $updateData = ['ledger' => $ledgerBalance];
            $this->patientSummaryRepository->updatePatientSummary($patientId, $updateData);

            return self::UPDATED;
        }

        $this->patientSummaryRepository->create([
            'pid'    => $patientId,
            'ledger' => 0,
        ]);

        return self::CREATED;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return float
     */
    private function modifyLedgerBalance($docId, $patientId)
    {
        $rowsForCountingLedgerBalance = $this->ledgerRepository
            ->getRowsForCountingLedgerBalance($docId, $patientId);

        $ledgerBalance = 0;
        foreach ($rowsForCountingLedgerBalance as $row) {
            if (isset($row->amount)) {
                $ledgerBalance -= $row->amount;
            }
            if (isset($row->paid_amount)) {
                $ledgerBalance += $row->paid_amount;
            }
        }

        return $ledgerBalance;
    }
}
