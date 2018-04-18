<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\MissingElementException;
use DentalSleepSolutions\Exceptions\ObjectTypeException;
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
     * @throws ObjectTypeException|MissingElementException
     */
    public function getLedgerRows(LedgerReportData $data, $reportType)
    {
        $ledgerRows = $this->queryLedgerRows($data, $reportType);

        if (!isset($ledgerRows['total']) || !isset($ledgerRows['result'])) {
            $keys = ['total', 'result'];
            throw new MissingElementException($keys, 'Rows array');
        }

        if (!$ledgerRows['result'] instanceof Collection) {
            throw new ObjectTypeException($ledgerRows['result'], Collection::class, 'Result');
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
     * @throws MissingElementException
     */
    private function modifyResult(array $row)
    {
        if (!isset($row['patientid'])) {
            $arrayName = 'Each row';
            $keys = ['patientid'];
            throw new MissingElementException($keys, $arrayName);
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
