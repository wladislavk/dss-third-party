<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Ledger;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Eloquent\Repositories\Interfaces\BackOfficeConditionalInterface;
use DentalSleepSolutions\Eloquent\Repositories\Interfaces\BackOfficeConditionalTrait;
use DentalSleepSolutions\Structs\LedgerReportData;
use DentalSleepSolutions\Structs\QueryCollections\ReportDataQueryCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Query\Builder as QueryBuilder;

class LedgerRepository extends AbstractRepository implements BackOfficeConditionalInterface
{
    use BackOfficeConditionalTrait;

    const SORT_COLUMNS = [
        'entry_date'  => 'entry_date',
        'producer'    => 'name',
        'patient'     => 'lastname',
        'description' => 'description',
        'amount'      => 'amount',
        'paid_amount' => 'paid_amount',
        'status'      => 'status',
    ];

    const DEFAULT_SORT_COLUMN = 'service_date';

    public function model()
    {
        return Ledger::class;
    }

    /**
     * @param LedgerReportData $data
     * @return array
     */
    public function getTodayList(LedgerReportData $data)
    {
        $queryJoinedWithTransactionCode = $this->model
            ->select(
                \DB::raw("'ledger_paid' AS ledger"),
                'dl.ledgerid AS ledgerid',
                'dl.service_date AS service_date',
                'dl.entry_date AS entry_date',
                'dl.amount AS amount',
                'dl.paid_amount AS paid_amount',
                'dl.status AS status',
                'dl.description AS description',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
                'pat.patientid AS patientid',
                'pat.firstname AS firstname',
                'pat.lastname AS lastname',
                'tc.type AS payer',
                \DB::raw("'' AS payment_type")
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function (JoinClause $query) use ($data) {
                $query
                    ->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $data->docId)
                ;
            })
            ->where('dl.docid', $data->docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0)
                ;
            })
            ->where('dl.service_date', Carbon::now())
        ;

        $queryJoinedWithLedgerPayment = $this->model
            ->select(
                \DB::raw("'ledger_payment' AS ledger"),
                'dlp.id AS ledgerid',
                'dlp.payment_date AS service_date',
                'dlp.entry_date AS entry_date',
                \DB::raw("'' AS amount"),
                'dlp.amount AS paid_amount',
                \DB::raw("'' AS status"),
                \DB::raw("'' AS description"),
                \DB::raw("CONCAT(p.first_name ,' ', p.last_name) AS name"),
                'pat.patientid AS patientid',
                'pat.firstname AS firstname',
                'pat.lastname AS lastname',
                'dlp.payer AS payer',
                'dlp.payment_type AS payment_type'
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $data->docId)
            ->where('dlp.amount', '!=', 0)
            ->where('dlp.payment_date', Carbon::now())
        ;

        $query = $this->model
            ->select(
                \DB::raw("'ledger' AS ledger"),
                'dl.ledgerid AS ledgerid',
                'dl.service_date AS service_date',
                'dl.entry_date AS entry_date',
                'dl.amount AS amount',
                'dl.paid_amount AS paid_amount',
                'dl.status AS status',
                'dl.description AS description',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
                'pat.patientid AS patientid',
                'pat.firstname AS firstname',
                'pat.lastname AS lastname',
                \DB::raw("'' AS payer"),
                \DB::raw("'' AS payment_type")
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
            ->where('dl.docid', $data->docId)
            ->where('dl.service_date', Carbon::now())
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0)
                ;
            })
            ->groupBy('dl.ledgerid')
            ->union($queryJoinedWithTransactionCode)
            ->union($queryJoinedWithLedgerPayment)
            ->orderBy($this->getSortColumnForList($data->sort), $data->sortDir)
        ;

        $list = $query->get();

        return [
            'total'  => count($list),
            'result' => $list->splice($data->page * $data->rowsPerPage, $data->rowsPerPage),
        ];
    }

    /**
     * @param LedgerReportData $data
     * @return array
     */
    public function getFullList(LedgerReportData $data)
    {
        $query = $this->model
            ->select('dl.*', 'p.name')
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->where('dl.docid', $data->docId)
        ;

        $totalNumber = $query->count();

        $resultQuery = $query
            ->orderBy($this->getSortColumnForList($data->sort), $data->sortDir)
            ->skip($data->page * $data->rowsPerPage)
            ->take($data->rowsPerPage)
        ;

        return [
            'total'  => $totalNumber,
            'result' => $resultQuery->get(),
        ];
    }

    /**
     * @param string $sort
     * @return string
     */
    private function getSortColumnForList($sort)
    {
        if (array_key_exists($sort, self::SORT_COLUMNS)) {
            return self::SORT_COLUMNS[$sort];
        }

        return self::DEFAULT_SORT_COLUMN;
    }

    /**
     * @param int $docId
     * @return Builder
     */
    public function getTotalChargesBaseQuery($docId)
    {
        $query = $this->model
            ->select(
                \DB::raw("COALESCE(dl.description, '') as payment_description"),
                \DB::raw('SUM(dl.amount) AS amount')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->where('dl.docid', $docId)
            ->whereRaw('COALESCE(dl.paid_amount, 0) = 0')
            ->where('dl.amount', '!=', 0)
            ->groupBy('payment_description')
        ;

        return $query;
    }

    /**
     * @param int $docId
     * @return array|Collection
     */
    public function getTotalCreditsUnspecified($docId)
    {
        $query = $this->model
            ->select(
                \DB::raw("COALESCE(dl.description, '') AS payment_description"),
                \DB::raw('SUM(dl.paid_amount) AS amount')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where('dl.paid_amount', '!=', 0)
            ->groupBy('payment_description')
        ;

        return $query->get();
    }

    /**
     * @param int $docId
     * @return Builder
     */
    public function getTotalCreditsTypeBaseQuery($docId)
    {
        $query = $this->model
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dlp.amount', '!=', 0)
            ->groupBy('payment_description')
        ;
        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsCreditsTypeQueryForReportToday(Builder $query)
    {
        $query = $query->select(
            \DB::raw("COALESCE(dlp.payment_type, '0') AS payment_description"),
            \DB::raw('COALESCE(sum(dlp.amount), 0) AS amount')
        );
        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsCreditsTypeQueryForReportNotToday(Builder $query)
    {
        $query = $query->select(
            \DB::raw("COALESCE(dlp.payment_type, '0') AS payment_description"),
            \DB::raw('COALESCE(sum(dlp.amount), 0) AS amount'),
            \DB::raw("COALESCE(dlp.payer, '') AS payment_payer")
        );
        return $query;
    }

    /**
     * @param int $docId
     * @return Builder
     */
    public function getTotalCreditsNamedBaseQuery($docId)
    {
        $query = $this->model
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function (JoinClause $query) use ($docId) {
                $query
                    ->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $docId)
                ;
            })
            ->where('dl.docid', $docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0)
                ;
            })
            ->whereRaw("COALESCE(tc.type, '') != ?", [Ledger::DSS_TRXN_TYPE_ADJ])
            ->groupBy('payment_description')
        ;

        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsCreditsNamedQueryForReportToday(Builder $query)
    {
        $query = $query->select(
            \DB::raw("COALESCE(dl.description, '') AS payment_description"),
            \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
        );
        return $query;
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsCreditsNamedQueryForReportNotToday(Builder $query)
    {
        $query = $query->select(
            \DB::raw("COALESCE(dl.description, '') AS payment_description"),
            \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount'),
            'tc.type AS payment_type'
        );
        return $query;
    }

    /**
     * @param int $docId
     * @return Builder
     */
    public function getTotalAdjustmentsBaseQuery($docId)
    {
        $query = $this->model
            ->select(
                \DB::raw("COALESCE(dl.description, '') AS payment_description"),
                \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function (JoinClause $query) use ($docId) {
                $query
                    ->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $docId)
                ;
            })
            ->where('dl.docid', $docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0)
                ;
            })
            ->where('tc.type', Ledger::DSS_TRXN_TYPE_ADJ)
            ->groupBy('payment_description')
        ;
        return $query;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function getTotalsServiceDateQuery(Builder $query)
    {
        return $query->where('dl.service_date', Carbon::now());
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function getTotalsPaymentDateQuery(Builder $query)
    {
        return $query->where('dlp.payment_date', Carbon::now());
    }

    /**
     * @param Builder $query
     * @param int $patientId
     * @return Builder
     */
    public function getTotalsPatientIdQuery(Builder $query, $patientId)
    {
        return $query->where('dl.patientid', $patientId);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsQueryGroupByPaymentPayer(Builder $query)
    {
        return $query->groupBy('payment_payer');
    }

    /**
     * @param Builder|QueryBuilder $query
     * @return Builder
     */
    public function getTotalsQueryGroupByPaymentType(Builder $query)
    {
        return $query->groupBy('payment_type');
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|Collection
     */
    public function getRowsForCountingLedgerBalance($docId, $patientId)
    {
        return $this->model
            ->select('dl.amount', \DB::raw('sum(pay.amount) as paid_amount'))
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dl.patientid', $patientId)
            ->groupBy('dl.ledgerid')
            ->get()
        ;
    }

    /**
     * @param LedgerReportData $data
     * @return Builder
     */
    public function getReportDataBaseQuery(LedgerReportData $data)
    {
        $query = $this->model
            ->select(
                'dl.patientid',
                'dl.docid',
                \DB::raw("'ledger_paid'"),
                'dl.ledgerid',
                'dl.service_date',
                'dl.entry_date',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
                'dl.description',
                'dl.amount',
                'dl.paid_amount',
                'dl.status',
                'dl.primary_claim_id',
                \DB::raw('IF(dl.primary_claim_id, di.mailed_date, dl.service_date)'),
                'tc.type',
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw('0 AS filed_by_bo')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function (JoinClause $query) use ($data) {
                $query
                    ->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $data->docId)
                ;
            })
            ->where('dl.docid', $data->docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0)
                ;
            })
            ->where('dl.patientid', $data->patientId)
        ;
        return $query;
    }

    /**
     * @param LedgerReportData $data
     * @return Builder
     */
    public function getReportDataBaseQueryWithLedgerPaymentFirst(LedgerReportData $data)
    {
        $query = $this->model
            ->select(
                'dl.patientid',
                'dl.docid',
                \DB::raw("'ledger'"),
                'dl.ledgerid',
                'dl.service_date',
                'dl.entry_date',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
                'dl.description',
                'dl.amount',
                \DB::raw('0.0 AS paid_amount'),
                'di.status',
                'dl.primary_claim_id',
                'di.mailed_date',
                \DB::raw("'' AS payer"),
                \DB::raw("'' AS payment_type"),
                'di.status AS claim_status',
                \DB::raw("'' AS filename"),
                \DB::raw("'' AS num_notes"),
                \DB::raw("'' AS num_fo_notes"),
                \DB::raw('0 AS filed_by_bo')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->where('dl.docid', $data->docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0)
                ;
            })
            ->where('dl.patientid', $data->patientId)
            ->groupBy('dl.ledgerid')
        ;
        return $query;
    }

    /**
     * @param LedgerReportData $data
     * @return Builder
     */
    public function getReportDataBaseQueryWithLedgerPaymentSecond(LedgerReportData $data)
    {
        $query = $this->model
            ->select(
                'dl.patientid',
                'dl.docid',
                \DB::raw("'ledger_payment'"),
                'dlp.id',
                'dlp.payment_date',
                'dlp.entry_date',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
                \DB::raw("''"),
                \DB::raw('0.0'),
                'dlp.amount',
                \DB::raw("''"),
                \DB::raw('IF(dl.secondary_claim_id && dlp.is_secondary, dl.secondary_claim_id, dl.primary_claim_id)'),
                \DB::raw('IF(dl.primary_claim_id, di.mailed_date, dl.service_date)'),
                'dlp.payer',
                'dlp.payment_type',
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw('0 AS filed_by_bo')
            )
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->where('dl.docid', $data->docId)
            ->where('dlp.amount', '!=', 0)
            ->where('dl.patientid', $data->patientId)
        ;
        return $query;
    }

    /**
     * @param ReportDataQueryCollection $queries
     * @param LedgerReportData $data
     * @return Builder
     */
    public function getReportDataUnionQuery(
        ReportDataQueryCollection $queries,
        LedgerReportData $data
    ) {
        $query = $queries->getFirstLedgerPaymentQuery()
            ->union($queries->getSecondLedgerPaymentQuery())
            ->union($queries->getBaseQuery())
            ->union($queries->getLedgerNotesUserQuery())
            ->union($queries->getLedgerNotesAdminQuery())
            ->union($queries->getLedgerStatementsQuery())
            ->union($queries->getInsuranceQuery())
            ->orderBy($this->getSortColumnForList($data->sort), $data->sortDir)
            ->skip($data->page * $data->rowsPerPage)
            ->take($data->rowsPerPage)
        ;
        return $query;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return Builder
     */
    public function getReportRowsNumberBaseQuery($docId, $patientId)
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(dl.ledgerid) as number'))
            ->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0)
                ;
            })
            ->where('dl.patientid', $patientId)
        ;

        return $query;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return Builder
     */
    public function getReportRowsNumberBaseQueryWithLedgerPaymentFirst($docId, $patientId)
    {
        $subQuery = $this->model
            ->select('dl.ledgerid')
            ->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where(function (Builder $query) {
                /** @var QueryBuilder $builder */
                $builder = $query;
                $builder
                    ->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0)
                ;
            })
            ->where('dl.patientid', $patientId)
            ->groupBy('dl.ledgerid')
        ;

        $query = $this->model
            ->select(\DB::raw('COUNT(ledgerid) as number'))
            ->from(\DB::raw("({$subQuery->toSql()}) as test"))
            ->mergeBindings($subQuery->getQuery())
        ;

        return $query;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return Builder
     */
    public function getReportRowsNumberBaseQueryWithLedgerPaymentSecond($docId, $patientId)
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(dl.ledgerid) as number'))
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dlp.amount', '!=', 0)
            ->where('dl.patientid', $patientId)
        ;
        return $query;
    }

    /**
     * @param int $primaryClaimId
     * @param array $data
     * @return bool|int
     */
    public function updateWherePrimaryClaimId($primaryClaimId, array $data = [])
    {
        return $this->model
            ->where('primary_claim_id', $primaryClaimId)
            ->update($data)
        ;
    }

    /**
     * @param int $patientId
     * @return Builder|QueryBuilder
     */
    public function getInsuranceLedgerDetailsQuery($patientId)
    {
        $backOfficeConditional = $this->filedByBackOfficeConditional('i');
        $query = $this->model
            ->select(
                'i.patientid',
                'i.docid',
                \DB::raw("'claim'"),
                'i.insuranceid',
                'i.adddate',
                'i.adddate',
                \DB::raw("'Claim'"),
                \DB::raw("'Insurance Claim'"),
                \DB::raw('(
                    SELECT SUM(dl2.amount)
                    FROM dental_ledger dl2
                        INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                    WHERE i2.insuranceid = i.insuranceid)'),
                \DB::raw('SUM(pay.amount)'),
                'i.status',
                'i.primary_claim_id',
                'i.mailed_date',
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw('(
                    SELECT COUNT(id)
                    FROM dental_claim_notes
                    WHERE claim_id = i.insuranceid)'),
                \DB::raw("(
                    SELECT COUNT(id)
                    FROM dental_claim_notes
                    WHERE claim_id = i.insuranceid
                        AND create_type = '1')"),
                \DB::raw($backOfficeConditional . ' AS filed_by_bo')
            )
            ->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->where('i.patientid', $patientId)
            ->groupBy('i.insuranceid')
        ;
        return $query;
    }

    /**
     * @param int $patientId
     * @return Builder
     */
    public function getInsuranceLedgerDetailsCount($patientId)
    {
        $subQuery = $this->model
            ->select('i.insuranceid')
            ->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->whereRaw('i.patientid = ?', [$patientId])
            ->groupBy('i.insuranceid')
        ;

        $subQueryString = $subQuery->toSql();

        $query = $this->model
            ->select(\DB::raw('COUNT(insuranceid) as number'))
            ->from(\DB::raw("($subQueryString) as test"))
            ->mergeBindings($subQuery->getQuery())
        ;
        return $query;
    }

    /**
     * @param int $patientId
     * @return Builder|QueryBuilder
     */
    public function getLedgerNoteLedgerDetailsUserQuery($patientId)
    {
        $userQuery = $this->model
            ->select(
                'n.patientid',
                'n.docid',
                \DB::raw("'note' AS ledger"),
                'n.id AS ledgerid',
                'n.service_date',
                'n.entry_date',
                \DB::raw("CONCAT('Note - ', p.first_name, ' ', p.last_name) AS name"),
                'n.note AS description',
                \DB::raw('0.0 AS amount'),
                \DB::raw('0.0 AS paid_amount'),
                'n.private AS status',
                \DB::raw('0 AS primary_claim_id'),
                \DB::raw('NULL AS mailed_date'),
                \DB::raw("'' AS payer"),
                \DB::raw("'' AS payment_type"),
                \DB::raw("'' AS claim_status"),
                \DB::raw("'' AS filename"),
                \DB::raw("'' AS num_notes"),
                \DB::raw("'' AS num_fo_notes"),
                \DB::raw("0 AS filed_by_bo")
            )
            ->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
            ->where('n.patientid', $patientId)
        ;

        return $userQuery;
    }

    /**
     * @param int $patientId
     * @return Builder|QueryBuilder
     */
    public function getLedgerNoteLedgerDetailsAdminQuery($patientId)
    {
        $adminQuery = $this->model
            ->select(
                'n.patientid',
                'n.docid',
                \DB::raw("'note'"),
                'n.id',
                'n.service_date',
                'n.entry_date',
                \DB::raw("CONCAT('Note - Backoffice ID - ', p.adminid)"),
                'n.note',
                \DB::raw('0.0'),
                \DB::raw('0.0'),
                'n.private',
                \DB::raw('0'),
                \DB::raw('NULL'),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("0 AS filed_by_bo")
            )
            ->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
            ->where('n.patientid', $patientId)
        ;

        return $adminQuery;
    }

    /**
     * @param int $patientId
     * @return Builder
     */
    public function getLedgerNoteLedgerDetailsUserCount($patientId)
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(n.id) as number'))
            ->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
            ->where('n.patientid', $patientId)
        ;
        return $query;
    }

    /**
     * @param int $patientId
     * @return Builder
     */
    public function getLedgerNoteLedgerDetailsAdminCount($patientId)
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(n.id) as number'))
            ->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
            ->where('n.patientid', $patientId)
        ;
        return $query;
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return Builder|QueryBuilder
     */
    public function getLedgerStatementLedgerDetailsQuery($docId, $patientId)
    {
        return $this->model
            ->select(
                's.patientid',
                \DB::raw("'$docId'"),
                \DB::raw("'statement'"),
                's.id',
                's.service_date',
                's.entry_date',
                \DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
                \DB::raw("'Ledger statement created (Click to view)'"),
                \DB::raw('0.0'),
                \DB::raw('0.0'),
                \DB::raw("''"),
                \DB::raw('0'),
                \DB::raw('NULL'),
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw("''"),
                's.filename',
                \DB::raw("''"),
                \DB::raw("''"),
                \DB::raw('0 AS filed_by_bo')
            )
            ->from(\DB::raw('dental_ledger_statement s'))
            ->join(\DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
            ->where('s.patientid', $patientId)
        ;
    }

    /**
     * @param int $patientId
     * @return Builder
     */
    public function getLedgerStatementLedgerDetailsCount($patientId)
    {
        $query = $this->model
            ->select(\DB::raw('COUNT(s.id) as number'))
            ->from(\DB::raw('dental_ledger_statement s'))
            ->join(\DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
            ->where('s.patientid', $patientId)
        ;

        return $query;
    }
}
