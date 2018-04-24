<?php

namespace DentalSleepSolutions\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;

class PatientSummaryUpdater
{
    const CREATED = 'Patient Summary was successfully inserted.';
    const UPDATED = 'Patient Summary was successfully updated.';

    /** @var LedgerRepository */
    private $ledgerRepository;

    /** @var PatientSummaryRepository */
    private $patientSummaryRepository;

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    public function __construct(
        LedgerRepository $ledgerRepository,
        PatientSummaryRepository $patientSummaryRepository,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->ledgerRepository = $ledgerRepository;
        $this->patientSummaryRepository = $patientSummaryRepository;
        $this->dbChangeWrapper = $dbChangeWrapper;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return string
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updatePatientSummary(int $docId, int $patientId): string
    {
        /** @var PatientSummary|null $patientSummary */
        $patientSummary = $this->patientSummaryRepository->getOneBy('pid', $patientId);

        if ($patientSummary) {
            $ledgerBalance = $this->modifyLedgerBalance($docId, $patientId);
            $patientSummary->ledger = $ledgerBalance;
            $this->dbChangeWrapper->save($patientSummary);
            return self::UPDATED;
        }

        $newPatientSummary = new PatientSummary();
        $newPatientSummary->pid = $patientId;
        $newPatientSummary->ledger = 0;
        $this->dbChangeWrapper->save($newPatientSummary);
        return self::CREATED;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return float
     */
    private function modifyLedgerBalance($docId, $patientId)
    {
        $rowsForCountingLedgerBalance = $this->ledgerRepository->getRowsForCountingLedgerBalance($docId, $patientId);

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
