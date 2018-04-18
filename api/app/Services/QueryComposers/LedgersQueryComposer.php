<?php

namespace DentalSleepSolutions\Services\QueryComposers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LedgerRepository;
use DentalSleepSolutions\Http\Controllers\LedgersController;
use DentalSleepSolutions\Structs\LedgerReportData;
use DentalSleepSolutions\Structs\QueryCollections\ReportDataQueryCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LedgersQueryComposer
{
    /** @var LedgerRepository */
    private $ledgerRepository;

    public function __construct(LedgerRepository $ledgerRepository)
    {
        $this->ledgerRepository = $ledgerRepository;
    }

    /**
     * @param string $type
     * @param int $docId
     * @param int $patientId
     * @return array|Collection
     */
    public function getTotalCharges($type, $docId, $patientId)
    {
        $query = $this->ledgerRepository->getTotalChargesBaseQuery($docId);

        $query = $this->modifyTotalsQuery($query, $type, $patientId);

        return $query->get();
    }

    /**
     * @param string $type
     * @param int $docId
     * @param int $patientId
     * @return array|Collection
     */
    public function getTotalAdjustments($type, $docId, $patientId)
    {
        $query = $this->ledgerRepository->getTotalAdjustmentsBaseQuery($docId);

        $query = $this->modifyTotalsQuery($query, $type, $patientId);

        return $query->get();
    }

    /**
     * @param string $type
     * @param int $docId
     * @param int $patientId
     * @return array|Collection
     */
    public function getTotalCreditsType($type, $docId, $patientId)
    {
        $query = $this->ledgerRepository->getTotalCreditsTypeBaseQuery($docId);

        $query = $this->getTotalCreditsTypeForType($query, $type);

        if ($patientId > 0) {
            $query = $this->ledgerRepository->getTotalsPatientIdQuery($query, $patientId);
        }

        if ($type == LedgersController::REPORT_TYPE_TODAY) {
            $query = $this->ledgerRepository->getTotalsPaymentDateQuery($query);
        }

        if ($type == LedgersController::REPORT_TYPE_FULL) {
            $query = $this->ledgerRepository->getTotalsQueryGroupByPaymentPayer($query);
        }

        return $query->get();
    }

    /**
     * @param string $type
     * @param int $docId
     * @param int $patientId
     * @return array|Collection
     */
    public function getTotalCreditsNamed($type, $docId, $patientId)
    {
        $query = $this->ledgerRepository->getTotalCreditsNamedBaseQuery($docId);

        $query = $this->getTotalCreditsNamedForType($query, $type);

        $query = $this->modifyTotalsQuery($query, $type, $patientId);

        if ($type == LedgersController::REPORT_TYPE_FULL) {
            $query = $this->ledgerRepository->getTotalsQueryGroupByPaymentType($query);
        }

        return $query->get();
    }

    /**
     * @param Builder $query
     * @param string $type
     * @param int $patientId
     * @return Builder
     */
    private function modifyTotalsQuery(Builder $query, $type, $patientId)
    {
        if ($patientId > 0) {
            $query = $this->ledgerRepository->getTotalsPatientIdQuery($query, $patientId);
        }

        if ($type == LedgersController::REPORT_TYPE_TODAY) {
            $query = $this->ledgerRepository->getTotalsServiceDateQuery($query);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    private function getTotalCreditsTypeForType(Builder $query, $type)
    {
        if ($type == LedgersController::REPORT_TYPE_TODAY) {
            return $this->ledgerRepository->getTotalsCreditsTypeQueryForReportToday($query);
        }
        return $this->ledgerRepository->getTotalsCreditsTypeQueryForReportNotToday($query);
    }

    /**
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    private function getTotalCreditsNamedForType(Builder $query, $type)
    {
        if ($type == LedgersController::REPORT_TYPE_TODAY) {
            return $this->ledgerRepository->getTotalsCreditsNamedQueryForReportToday($query);
        }
        return $this->ledgerRepository->getTotalsCreditsNamedQueryForReportNotToday($query);
    }

    /**
     * @param LedgerReportData $data
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getReportData(LedgerReportData $data)
    {
        $queries = new ReportDataQueryCollection();
        $queries
            ->setBaseQuery(
                $this->ledgerRepository->getReportDataBaseQuery($data)
            )
            ->setFirstLedgerPaymentQuery(
                $this->ledgerRepository->getReportDataBaseQueryWithLedgerPaymentFirst($data)
            )
            ->setSecondLedgerPaymentQuery(
                $this->ledgerRepository->getReportDataBaseQueryWithLedgerPaymentSecond($data)
            )
            ->setLedgerNotesUserQuery(
                $this->ledgerRepository->getLedgerNoteLedgerDetailsUserQuery($data->patientId)
            )
            ->setLedgerNotesAdminQuery(
                $this->ledgerRepository->getLedgerNoteLedgerDetailsAdminQuery($data->patientId)
            )
            ->setLedgerStatementsQuery(
                $this->ledgerRepository->getLedgerStatementLedgerDetailsQuery($data->docId, $data->patientId)
            )
            ->setInsuranceQuery(
                $this->ledgerRepository->getInsuranceLedgerDetailsQuery($data->patientId)
            )
        ;

        $unionQuery = $this->ledgerRepository->getReportDataUnionQuery($queries, $data);
        return $unionQuery->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return int
     */
    public function getReportRowsNumber($docId, $patientId)
    {
        $queryNumber = $this->getNumber(
            $this->ledgerRepository->getReportRowsNumberBaseQuery($docId, $patientId)
        );
        $firstLedgerPaymentNumber = $this->getNumber(
            $this->ledgerRepository->getReportRowsNumberBaseQueryWithLedgerPaymentFirst($docId, $patientId)
        );
        $secondLedgerPaymentNumber = $this->getNumber(
            $this->ledgerRepository->getReportRowsNumberBaseQueryWithLedgerPaymentSecond($docId, $patientId)
        );

        $ledgerNotesUserRowsNumber = $this->getNumber(
            $this->ledgerRepository->getLedgerNoteLedgerDetailsUserCount($patientId)
        );
        $ledgerNotesAdminRowsNumber = $this->getNumber(
            $this->ledgerRepository->getLedgerNoteLedgerDetailsAdminCount($patientId)
        );
        $ledgerStatementsRowsNumber = $this->getNumber(
            $this->ledgerRepository->getLedgerStatementLedgerDetailsCount($patientId)
        );
        $insuranceRowsNumber = $this->getNumber(
            $this->ledgerRepository->getInsuranceLedgerDetailsCount($patientId)
        );

        $totalNumber =
            $firstLedgerPaymentNumber
            +
            $secondLedgerPaymentNumber
            +
            $queryNumber
            +
            $ledgerNotesUserRowsNumber
            +
            $ledgerNotesAdminRowsNumber
            +
            $ledgerStatementsRowsNumber
            +
            $insuranceRowsNumber
        ;

        return $totalNumber;
    }

    /**
     * @param Builder $query
     * @return int
     */
    private function getNumber(Builder $query)
    {
        $model = $query->first();
        if ($model) {
            return $model->number;
        }
        return 0;
    }
}
