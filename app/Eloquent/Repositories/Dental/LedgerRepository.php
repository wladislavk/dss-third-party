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
     * @param LedgerNote $ledgerNoteModel
     * @param LedgerStatement $ledgerStatementModel
     * @param Insurance $insuranceModel
     * @param array $data
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getReportData(
        LedgerNote $ledgerNoteModel,
        LedgerStatement $ledgerStatementModel,
        Insurance $insuranceModel,
        array $data
    ) {
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

        $ledgerNotesQuery = $ledgerNoteModel->getLedgerDetailsQuery($data['patient_id']);
        $ledgerStatementsQuery = $ledgerStatementModel->getLedgerDetailsQuery($data['doc_id'], $data['patient_id']);
        $insuranceQuery = $insuranceModel->getLedgerDetailsQuery($data['patient_id']);

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
     * @param LedgerNote $ledgerNoteModel
     * @param LedgerStatement $ledgerStatementModel
     * @param Insurance $insuranceModel
     * @param int $docId
     * @param int $patientId
     * @return int
     */
    public function getReportRowsNumber(
        LedgerNote $ledgerNoteModel,
        LedgerStatement $ledgerStatementModel,
        Insurance $insuranceModel,
        $docId,
        $patientId
    ) {
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

        $ledgerNotesRowsNumber = $ledgerNoteModel->getLedgerDetailsRowsNumber($patientId);
        $ledgerStatementsRowsNumber = $ledgerStatementModel->getLedgerDetailsRowsNumber($patientId);
        $insuranceRowsNumber = $insuranceModel->getLedgerDetailsRowsNumber($patientId);
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
}
