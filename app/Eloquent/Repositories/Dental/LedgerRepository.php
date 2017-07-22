<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Insurance;
use DentalSleepSolutions\Eloquent\Models\Dental\Ledger;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerNote;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;
use Prettus\Repository\Eloquent\BaseRepository;

class LedgerRepository extends BaseRepository
{
    public function model()
    {
        return Ledger::class;
    }

    /**
     * @param int $docId
     * @param int $page
     * @param int $rowsPerPage
     * @param string|null $sort
     * @param string $sortDir
     * @return array
     */
    public function getTodayList($docId, $page, $rowsPerPage, $sort, $sortDir)
    {
        $queryJoinedWithTransactionCode = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $docId);
            })->where('dl.docid', $docId)
            ->where(function ($query) {
                $query->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0);
            })->where('dl.service_date', Carbon::now());

        $queryJoinedWithLedgerPayment = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dlp.amount', '!=', 0)
            ->where('dlp.payment_date', Carbon::now());

        $query = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
            ->leftJoin(\DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
            ->where('dl.docid', $docId)
            ->where('dl.service_date', Carbon::now())
            ->where(function ($query) {
                $query->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0);
            })->groupBy('dl.ledgerid')
            ->union($queryJoinedWithTransactionCode)
            ->union($queryJoinedWithLedgerPayment)
            ->orderBy($this->getSortColumnForList($sort), $sortDir);

        $list = $query->get();

        return [
            'total'  => count($list),
            'result' => $list->splice($page * $rowsPerPage, $rowsPerPage),
        ];
    }

    /**
     * @param int $docId
     * @param int $page
     * @param int $rowsPerPage
     * @param string|null $sort
     * @param string $sortDir
     * @return array
     */
    public function getFullList($docId, $page, $rowsPerPage, $sort, $sortDir)
    {
        $query = $this->model
            ->select('dl.*', 'p.name')
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->where('dl.docid', $docId)
        ;

        $totalNumber = $query->count();

        $resultQuery = $query
            ->orderBy($this->getSortColumnForList($sort), $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage)
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
        $sortColumns = [
            'entry_date'  => 'entry_date',
            'producer'    => 'name',
            'patient'     => 'lastname',
            'description' => 'description',
            'amount'      => 'amount',
            'paid_amount' => 'paid_amount',
            'status'      => 'status',
        ];

        $sortColumn = 'service_date';
        if (array_key_exists($sort, $sortColumns)) {
            $sortColumn = $sortColumns[$sort];
        }

        return $sortColumn;
    }

    /**
     * @param int $docId
     * @param string $type
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTotalCharges($docId, $type, $patientId)
    {
        if ($type == 'today' || $type == 'full') {
            $query = $this->model->select(
                \DB::raw("COALESCE(dl.description, '') as payment_description"),
                \DB::raw('SUM(dl.amount) AS amount')
            )->from(\DB::raw('dental_ledger dl'))
                ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->where('dl.docid', $docId)
                ->whereRaw('COALESCE(dl.paid_amount, 0) = 0')
                ->where('dl.amount', '!=', 0);

            if ($patientId > 0) {
                $query = $query->where('dl.patientid', $patientId);
            }

            if ($type == 'today') {
                $query = $query->where('dl.service_date', Carbon::now());
            }

            $query = $query->groupBy('payment_description');

            return $query->get();
        }
        return [];
    }

    /**
     * @param int $docId
     * @param string $type
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTotalCredits($docId, $type, $patientId)
    {
        if ($type == 'today' || $type == 'full') {
            if ($type == 'today') {
                $totalCreditsType = $this->model->select(
                    \DB::raw("COALESCE(dlp.payment_type, '0') AS payment_description"),
                    \DB::raw('COALESCE(sum(dlp.amount), 0) AS amount')
                );

                $totalCreditsNamed = $this->model->select(
                    \DB::raw("COALESCE(dl.description, '') AS payment_description"),
                    \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
                );
            } else {
                $totalCreditsType = $this->model->select(
                    \DB::raw("COALESCE(dlp.payment_type, '0') AS payment_description"),
                    \DB::raw('COALESCE(sum(dlp.amount), 0) AS amount'),
                    \DB::raw("COALESCE(dlp.payer, '') AS payment_payer")
                );

                $totalCreditsNamed = $this->model->select(
                    \DB::raw("COALESCE(dl.description, '') AS payment_description"),
                    \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount'),
                    'tc.type AS payment_type'
                );
            }

            $totalCreditsType = $totalCreditsType->from(\DB::raw('dental_ledger dl'))
                ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
                ->where('dl.docid', $docId)
                ->where('dlp.amount', '!=', 0);

            $totalCreditsNamed = $totalCreditsNamed->from(\DB::raw('dental_ledger dl'))
                ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(\DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                    $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                        ->where('tc.docid', '=', $docId);
                })->where('dl.docid', $docId)
                ->where(function($query) {
                    $query->whereNotNull('dl.paid_amount')
                        ->where('dl.paid_amount', '!=', 0);
                })->whereRaw("COALESCE(tc.type, '') != ?", [Ledger::DSS_TRXN_TYPE_ADJ]);

            if ($patientId > 0) {
                $totalCreditsType = $totalCreditsType->where('dl.patientid', $patientId);

                $totalCreditsNamed = $totalCreditsNamed->where('dl.patientid', $patientId);
            }

            if ($type == 'today') {
                $totalCreditsType = $totalCreditsType->where('dlp.payment_date', Carbon::now());

                $totalCreditsNamed = $totalCreditsNamed->where('dl.service_date', Carbon::now());
            }

            $totalCreditsType = $totalCreditsType->groupBy('payment_description');

            if ($type == 'full') {
                $totalCreditsType = $totalCreditsType->groupBy('payment_payer');

                $totalCreditsNamed = $totalCreditsNamed->groupBy('payment_type');
            }

            $totalCreditsNamed = $totalCreditsNamed->groupBy('payment_description');

            $totalCreditsType = $totalCreditsType->get();

            $totalCreditsNamed = $totalCreditsNamed->get();

            return [
                'type'  => $totalCreditsType,
                'named' => $totalCreditsNamed,
            ];
        }
        $query = $this->select(
            \DB::raw("COALESCE(dl.description, '') AS payment_description"),
            \DB::raw('SUM(dl.paid_amount) AS amount')
        )->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where('dl.paid_amount', '!=', 0)
            ->groupBy('payment_description');

        return $query->get();
    }

    /**
     * @param int $docId
     * @param string $type
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTotalAdjustments($docId, $type, $patientId)
    {
        if ($type == 'today' || $type == 'full') {
            $query = $this->model->select(
                \DB::raw("COALESCE(dl.description, '') AS payment_description"),
                \DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
            )->from(\DB::raw('dental_ledger dl'))
                ->join(\DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(\DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                    $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                        ->where('tc.docid', '=', $docId);
                })->where('dl.docid', $docId)
                ->where(function ($query) {
                    $query->whereNotNull('dl.paid_amount')
                        ->where('dl.paid_amount', '!=', 0);
                })->where('tc.type', Ledger::DSS_TRXN_TYPE_ADJ);

            if ($type == 'today') {
                $query = $query->where('dl.service_date', Carbon::now());
            }

            if ($patientId > 0) {
                $query = $query->where('dl.patientid', $patientId);
            }

            return $query->groupBy('payment_description')->get();
        }
        return [];
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getRowsForCountingLedgerBalance($docId, $patientId)
    {
        return $this->model->select('dl.amount', \DB::raw('sum(pay.amount) as paid_amount'))
            ->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dl.patientid', $patientId)
            ->groupBy('dl.ledgerid')
            ->get();
    }

    /**
     * @param array $data
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getReportData(array $data)
    {
        $defaultData = [
            'doc_id'        => 0,
            'patient_id'    => 0,
            'page'          => 0,
            'rows_per_page' => 0,
            'sort'          => '',
            'sort_dir'      => '',
        ];

        $data = array_merge($defaultData, $data);

        $queryJoinedWithLedgerPayment = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->where('dl.docid', $data['doc_id'])
            ->where(function ($query) {
                $query->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0);
            });

        $queryJoinedWithLedgerPayment1 = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->where('dl.docid', $data['doc_id'])
            ->where('dlp.amount', '!=', 0);

        $query = $this->model->select(
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
        )->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->leftJoin(\DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
            ->leftJoin(\DB::raw('dental_transaction_code tc'), function ($query) use ($data) {
                $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                    ->where('tc.docid', '=', $data['doc_id']);
            })->where('dl.docid', $data['doc_id'])
            ->where(function ($query) {
                $query->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0);
            });

        if ($data['patient_id']) {
            $queryJoinedWithLedgerPayment = $queryJoinedWithLedgerPayment->where('dl.patientid', $data['patient_id']);
            $queryJoinedWithLedgerPayment1 = $queryJoinedWithLedgerPayment1->where('dl.patientid', $data['patient_id']);
            $query = $query->where('dl.patientid', $data['patient_id']);
        }

        $queryJoinedWithLedgerPayment = $queryJoinedWithLedgerPayment->groupBy('dl.ledgerid');

        $ledgerNotesQuery = $this->getLedgerNoteLedgerDetailsQuery($data['patient_id']);
        $ledgerStatementsQuery = $this->getLedgerStatementLedgerDetailsQuery($data['doc_id'], $data['patient_id']);
        $insuranceQuery = $this->getInsuranceLedgerDetailsQuery($data['patient_id']);

        $query = $queryJoinedWithLedgerPayment->union($queryJoinedWithLedgerPayment1)
            ->union($query)
            ->union($ledgerNotesQuery['users'])
            ->union($ledgerNotesQuery['admins'])
            ->union($ledgerStatementsQuery)
            ->union($insuranceQuery)
            ->orderBy($this->getSortColumnForList($data['sort']), $data['sort_dir'])
            ->skip($data['page'] * $data['rows_per_page'])
            ->take($data['rows_per_page']);

        return $query->get();
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return int
     */
    public function getReportRowsNumber($docId, $patientId)
    {
        $subQueryJoinedWithLedgerPayment = $this->model->select('dl.ledgerid')
            ->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where(function ($query) {
                $query->whereNull('dl.paid_amount')
                    ->orWhere('dl.paid_amount', 0);
            })->where('dl.patientid', $patientId)
            ->groupBy('dl.ledgerid');

        $queryJoinedWithLedgerPayment = $this->model->select(\DB::raw('COUNT(ledgerid) as number'))
            ->from(\DB::raw("({$subQueryJoinedWithLedgerPayment->toSql()}) as test"))
            ->mergeBindings($subQueryJoinedWithLedgerPayment->getQuery())
            ->first();

        $queryJoinedWithLedgerPayment1 = $this->model->select(
            \DB::raw('COUNT(dl.ledgerid) as number')
        )->from(\DB::raw('dental_ledger dl'))
            ->leftJoin(\DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dlp.amount', '!=', 0)
            ->where('dl.patientid', $patientId)
            ->first();

        $query = $this->model->select(
            \DB::raw('COUNT(dl.ledgerid) as number')
        )->from(\DB::raw('dental_ledger dl'))
            ->where('dl.docid', $docId)
            ->where(function ($query) {
                $query->whereNotNull('dl.paid_amount')
                    ->where('dl.paid_amount', '!=', 0);
            })->where('dl.patientid', $patientId)
            ->first();

        $ledgerNotesRowsNumber = $this->getLedgerNoteLedgerDetailsRowsNumber($patientId);
        $ledgerStatementsRowsNumber = $this->getLedgerStatementLedgerDetailsRowsNumber($patientId);
        $insuranceRowsNumber = $this->getInsuranceLedgerDetailsRowsNumber($patientId);
        $totalNumber = (!empty($queryJoinedWithLedgerPayment) ? $queryJoinedWithLedgerPayment->number : 0)
            + (!empty($queryJoinedWithLedgerPayment1) ? $queryJoinedWithLedgerPayment1->number : 0)
            + (!empty($query) ? $query->number : 0)
            + $ledgerNotesRowsNumber
            + $ledgerStatementsRowsNumber
            + $insuranceRowsNumber;

        return $totalNumber;
    }

    /**
     * @param int $primaryClaimId
     * @param array $data
     * @return bool|int
     */
    public function updateWherePrimaryClaimId($primaryClaimId, array $data = [])
    {
        return $this->model->where('primary_claim_id', $primaryClaimId)->update($data);
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    /**
     * @param int $patientId
     * @return Insurance
     */
    private function getInsuranceLedgerDetailsQuery($patientId)
    {
        return $this->model->select(
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
            \DB::raw(Insurance::filedByBackOfficeConditional($claimAlias = 'i') . ' as filed_by_bo')
        )->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->where('i.patientid', $patientId)
            ->groupBy('i.insuranceid');
    }

    /**
     * @param int $patientId
     * @return int
     */
    private function getInsuranceLedgerDetailsRowsNumber($patientId)
    {
        $subQuery = $this->model->select('i.insuranceid')
            ->from(\DB::raw('dental_insurance i'))
            ->leftJoin(\DB::raw('dental_ledger dl'), 'dl.primary_claim_id', '=', 'i.insuranceid')
            ->leftJoin(\DB::raw('dental_ledger_payment pay'), 'dl.ledgerid', '=', 'pay.ledgerid')
            ->whereRaw('i.patientid = ?', [$patientId])
            ->groupBy('i.insuranceid');

        $subQueryString = $subQuery->toSql();

        $query = $this->model->select(\DB::raw('COUNT(insuranceid) as number'))
            ->from(\DB::raw("($subQueryString) as test"))
            ->mergeBindings($subQuery->getQuery())
            ->first();

        return !empty($query) ? $query->number : 0;
    }

    /**
     * @param int $patientId
     * @return array
     */
    public function getLedgerNoteLedgerDetailsQuery($patientId)
    {
        $userQuery = $this->model->select(
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
        )->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
            ->where('n.patientid', $patientId);

        $adminQuery = $this->model->select(
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
        )->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
            ->where('n.patientid', $patientId);

        return [
            'users'  => $userQuery,
            'admins' => $adminQuery,
        ];
    }

    /**
     * @param int $patientId
     * @return int
     */
    public function getLedgerNoteLedgerDetailsRowsNumber($patientId)
    {
        $userQuery = $this->model->select(
            \DB::raw('COUNT(n.id) as number')
        )->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('dental_users p'), 'n.producerid', '=', 'p.userid')
            ->where('n.patientid', $patientId)
            ->first();

        $adminQuery = $this->model->select(
            \DB::raw('COUNT(n.id) as number')
        )->from(\DB::raw('dental_ledger_note n'))
            ->join(\DB::raw('admin p'), 'n.admin_producerid', '=', 'p.adminid')
            ->where('n.patientid', $patientId)
            ->first();

        return (!empty($userQuery) ? $userQuery->number : 0)
            + (!empty($adminQuery) ? $adminQuery->number : 0);
    }

    /**
     * @param int $docId
     * @param int $patientId
     * @return LedgerStatement
     */
    public function getLedgerStatementLedgerDetailsQuery($docId, $patientId)
    {
        return $this->model->select(
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
        )->from(\DB::raw('dental_ledger_statement s'))
            ->join(\DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
            ->where('s.patientid', $patientId);
    }

    /**
     * @param int $patientId
     * @return int
     */
    public function getLedgerStatementLedgerDetailsRowsNumber($patientId)
    {
        $query = $this->model->select(
            \DB::raw('COUNT(s.id) as number')
        )->from(\DB::raw('dental_ledger_statement s'))
            ->join(\DB::raw('dental_users p'), 's.producerid', '=', 'p.userid')
            ->where('s.patientid', $patientId)
            ->first();

        return !empty($query) ? $query->number : 0;
    }
}
