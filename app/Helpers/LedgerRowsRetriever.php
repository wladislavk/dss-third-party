<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use DentalSleepSolutions\Structs\LedgerReportData;
use Illuminate\Database\Eloquent\Collection;

class LedgerRowsRetriever
{
    /** @var LedgerRepository */
    private $ledgerRepository;

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(LedgerRepository $ledgerRepository, PatientRepository $patientRepository)
    {
        $this->ledgerRepository = $ledgerRepository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param LedgerReportData $data
     * @param string $reportType
     * @return array
     * @throws GeneralException
     */
    public function getLedgerRows(LedgerReportData $data, $reportType)
    {
        $ledgerRows = $this->queryLedgerRows($data, $reportType);

        if (!isset($ledgerRows['total']) || !isset($ledgerRows['result'])) {
            throw new GeneralException('Rows array must contain keys \'result\' and \'total\'');
        }

        if (!$ledgerRows['result'] instanceof Collection) {
            throw new GeneralException('Result must be of type ' . Collection::class);
        }

        if ($ledgerRows['total'] > 0) {
            foreach ($ledgerRows['result'] as $key => $element) {
                $ledgerRows['result'][$key] = $this->modifyResult($element);
            }
        }

        return $ledgerRows;
    }

    /**
     * @param LedgerReportData $data
     * @param string $reportType
     * @return array
     */
    private function queryLedgerRows(LedgerReportData $data, $reportType)
    {
        if ($reportType == LedgersController::REPORT_TYPE_TODAY) {
            return $this->ledgerRepository->getTodayList($data);
        }
        return $this->ledgerRepository->getFullList($data);
    }

    /**
     * @param array $row
     * @return array
     * @throws GeneralException
     */
    private function modifyResult(array $row)
    {
        if (!isset($row['patientid'])) {
            throw new GeneralException('Each row must contain key \'patientid\'');
        }

        $patients = $this->patientRepository->getWithFilter(
            ['firstname', 'lastname'],
            ['patientid' => $row['patientid']]
        );

        $row['patient_info'] = null;
        if (isset($patients[0])) {
            $row['patient_info'] = $patients[0];
        }

        return $row;
    }
}
