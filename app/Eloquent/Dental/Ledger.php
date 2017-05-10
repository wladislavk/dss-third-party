<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Ledger as Resource;
use DentalSleepSolutions\Contracts\Repositories\Ledgers as Repository;
use Carbon\Carbon;
use DB;

class Ledger extends Model implements Resource, Repository
{
    const DSS_TRXN_TYPE_ADJ = 6;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['ledgerid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ledgerid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['service_date', 'entry_date', 'percase_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getForSendClaim($pid, $insid, $docid, $type)
    {
        return self::select('dental_ledger.*')
            ->join('dental_users', 'dental_users.userid', '=', 'dental_ledger.docid')
            ->join('dental_transaction_code', 'dental_transaction_code.transaction_code', '=', 'dental_ledger.transaction_code')
            ->leftJoin('dental_place_service', 'dental_transaction_code.place', '=', 'dental_place_service.place_serviceid')
            ->where('dental_ledger.primary_claim_id', $insid)
            ->where('dental_ledger.patientid', $pid)
            ->where('dental_ledger.docid', $docid)
            ->where('dental_transaction_code.docid', $docid)
            ->where('dental_transaction_code.type', $type)
            ->orderBy('dental_ledger.service_date', 'ASC')
            ->get();
    }

    public function getTodayList($docId, $page, $rowsPerPage, $sort, $sortDir = 'desc')
    {
        $queryJoinedWithTransactionCode = $this->select(
            DB::raw("'ledger_paid' AS ledger"),
            'dl.ledgerid AS ledgerid',
            'dl.service_date AS service_date',
            'dl.entry_date AS entry_date',
            'dl.amount AS amount',
            'dl.paid_amount AS paid_amount',
            'dl.status AS status',
            'dl.description AS description',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
            'pat.patientid AS patientid',
            'pat.firstname AS firstname',
            'pat.lastname AS lastname',
            'tc.type AS payer',
            DB::raw("'' AS payment_type")
        )->from(DB::raw('dental_ledger dl'))
        ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
        ->leftJoin(DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
        ->leftJoin(DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
            $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                ->where('tc.docid', '=', $docId);
        })->where('dl.docid', $docId)
        ->where(function ($query) {
            $query->whereNotNull('dl.paid_amount')
                ->where('dl.paid_amount', '!=', 0);
        })->where('dl.service_date', Carbon::now());

        $queryJoinedWithLedgerPayment = $this->select(
            DB::raw("'ledger_payment' AS ledger"),
            'dlp.id AS ledgerid',
            'dlp.payment_date AS service_date',
            'dlp.entry_date AS entry_date',
            DB::raw("'' AS amount"),
            'dlp.amount AS paid_amount',
            DB::raw("'' AS status"),
            DB::raw("'' AS description"),
            DB::raw("CONCAT(p.first_name ,' ', p.last_name) AS name"),
            'pat.patientid AS patientid',
            'pat.firstname AS firstname',
            'pat.lastname AS lastname',
            'dlp.payer AS payer',
            'dlp.payment_type AS payment_type'
        )->from(DB::raw('dental_ledger dl'))
        ->join(DB::raw('dental_patients pat'), 'dl.patientid', '=', 'pat.patientid')
        ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
        ->leftJoin(DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
        ->where('dl.docid', $docId)
        ->where('dlp.amount', '!=', 0)
        ->where('dlp.payment_date', Carbon::now());

        $query = $this->select(
            DB::raw("'ledger' AS ledger"),
            'dl.ledgerid AS ledgerid',
            'dl.service_date AS service_date',
            'dl.entry_date AS entry_date',
            'dl.amount AS amount',
            'dl.paid_amount AS paid_amount',
            'dl.status AS status',
            'dl.description AS description',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
            'pat.patientid AS patientid',
            'pat.firstname AS firstname',
            'pat.lastname AS lastname',
            DB::raw("'' AS payer"),
            DB::raw("'' AS payment_type")
        )->from(DB::raw('dental_ledger dl'))
        ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
        ->leftJoin(DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
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
            'result' => $list->splice($page * $rowsPerPage, $rowsPerPage)
        ];
    }

    public function getFullList($docId, $page, $rowsPerPage, $sort, $sortDir = 'desc')
    {
        $query = $this->select('dl.*', 'p.name')
            ->from(DB::raw('dental_ledger dl'))
            ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
            ->where('dl.docid', $docId);

        $totalNumber = $query->count();

        $resultQuery = $query->orderBy($this->getSortColumnForList($sort), $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return [
            'total'  => $totalNumber,
            'result' => $resultQuery->get()
        ];
    }

    public function getTotalCharges($docId, $type = 'today', $patientId = 0)
    {
        if ($type == 'today' || $type == 'full') {
            $query = $this->select(
                    DB::raw("COALESCE(dl.description, '') as description"),
                    DB::raw('SUM(dl.amount) AS amount')
                )->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->where('dl.docid', $docId)
                ->whereRaw('COALESCE(dl.paid_amount, 0) = 0')
                ->where('dl.amount', '!=', 0);

            if ($patientId > 0) {
                $query = $query->where('dl.patientid', $patientId);
            }

            if ($type == 'today') {
                $query = $query->where('dl.service_date', Carbon::now());
            }

            $query = $query->groupBy('description');

            return $query->get();
        } else {
            return [];
        }
    }

    public function getTotalCredits($docId, $type = 'today', $patientId = 0)
    {
        if ($type == 'today' || $type == 'full') {
            $totalCreditsType = $this->select(
                    DB::raw("COALESCE(dlp.payment_type, '0') AS description"),
                    DB::raw('COALESCE(sum(dlp.amount), 0) AS amount')
                )->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
                ->where('dl.docid', $docId)
                ->where('dlp.amount', '!=', 0);

            if ($patientId > 0) {
                $totalCreditsType = $totalCreditsType->where('dl.patientid', $patientId);
            }

            if ($type == 'today') {
                $totalCreditsType = $totalCreditsType->where('dlp.payment_date', Carbon::now());
            }

            $totalCreditsType = $totalCreditsType->groupBy('description')->get();

            $totalCreditsNamed = $this->select(
                    DB::raw("COALESCE(dl.description, '') AS description"),
                    DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
                )->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                    $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                        ->where('tc.docid', '=', $docId);
                })->where('dl.docid', $docId)
                ->where(function($query) {
                    $query->whereNotNull('dl.paid_amount')
                        ->where('dl.paid_amount', '!=', 0);
                })->whereRaw("COALESCE(tc.type, '') != ?", [self::DSS_TRXN_TYPE_ADJ]);

            if ($patientId > 0) {
                $totalCreditsNamed = $totalCreditsNamed->where('dl.patientid', $patientId);
            }

            if ($type == 'today') {
                $totalCreditsNamed = $totalCreditsNamed->where('dl.service_date', Carbon::now());
            }

            $totalCreditsNamed = $totalCreditsNamed->groupBy('description')->get();

            return [
                'type'  => $totalCreditsType,
                'named' => $totalCreditsNamed
            ];
        } else {
            $query = $this->select(
                    DB::raw("COALESCE(dl.description, '') AS description"),
                    DB::raw('SUM(dl.paid_amount) AS amount')
                )->from(DB::raw('dental_ledger dl'))
                ->where('dl.docid', $docId)
                ->where('dl.paid_amount', '!=', 0)
                ->groupBy('description');

            return $query->get();
        }
    }

    public function getTotalAdjustments($docId, $type = 'today', $patientId = 0)
    {
        if ($type == 'today') {
            $query = $this->select(
                    DB::raw("COALESCE(dl.description, '') AS description"),
                    DB::raw('COALESCE(sum(dl.paid_amount), 0) AS amount')
                )->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                    $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                        ->where('tc.docid', '=', $docId);
                })->where('dl.docid', $docId)
                ->where(function ($query) {
                    $query->whereNotNull('dl.paid_amount')
                        ->where('dl.paid_amount', '!=', 0);
                })->where('tc.type', self::DSS_TRXN_TYPE_ADJ)
                ->where('dl.service_date', Carbon::now());

            if ($patientId > 0) {
                $query = $query->where('dl.patientid', $patientId);
            }

            return $query->groupBy('description')->get();
        } else {
            return [];
        }
    }

    public function getRowsForCountingLedgerBalance($docId, $patientId)
    {
        return $this->select('dl.amount', DB::raw('sum(pay.amount) as paid_amount'))
            ->from(DB::raw('dental_ledger dl'))
            ->leftJoin(DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
            ->where('dl.docid', $docId)
            ->where('dl.patientid', $patientId)
            ->groupBy('dl.ledgerid')
            ->get();
    }

    public function getReportData(
        $ledgerNoteModel,
        $ledgerStatementModel,
        $insuranceModel,
        $data
    ) {
        $defaultData = [
            'doc_id'        => 0,
            'patient_id'    => 0,
            'page'          => 0,
            'rows_per_page' => 0,
            'sort'          => '',
            'sort_dir'      => ''
        ];

        $data = array_merge($defaultData, $data);

        $queryJoinedWithLedgerPayment = $this->select(
            'dl.patientid',
            'dl.docid',
            DB::raw("'ledger'"),
            'dl.ledgerid',
            'dl.service_date',
            'dl.entry_date',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name) AS name"),
            'dl.description',
            'dl.amount',
            DB::raw('0.0 AS paid_amount'),
            'di.status',
            'dl.primary_claim_id',
            'di.mailed_date',
            DB::raw("'' AS payer"),
            DB::raw("'' AS payment_type"),
            'di.status AS claim_status',
            DB::raw("'' AS filename"),
            DB::raw("'' AS num_notes"),
            DB::raw("'' AS num_fo_notes"),
            DB::raw('0 AS filed_by_bo')
        )->from(DB::raw('dental_ledger dl'))
        ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
        ->leftJoin(DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
        ->leftJoin(DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
        ->where('dl.docid', $data['doc_id'])
        ->where(function ($query) {
            $query->whereNull('dl.paid_amount')
                ->orWhere('dl.paid_amount', 0);
        });

        $queryJoinedWithLedgerPayment1 = $this->select(
            'dl.patientid',
            'dl.docid',
            DB::raw("'ledger_payment'"),
            'dlp.id',
            'dlp.payment_date',
            'dlp.entry_date',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
            DB::raw("''"),
            DB::raw('0.0'),
            'dlp.amount',
            DB::raw("''"),
            DB::raw('IF(dl.secondary_claim_id && dlp.is_secondary, dl.secondary_claim_id, dl.primary_claim_id)'),
            DB::raw('IF(dl.primary_claim_id, di.mailed_date, dl.service_date)'),
            'dlp.payer',
            'dlp.payment_type',
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw('0 AS filed_by_bo')
        )->from(DB::raw('dental_ledger dl'))
        ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
        ->leftJoin(DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
        ->leftJoin(DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
        ->where('dl.docid', $data['doc_id'])
        ->where('dlp.amount', '!=', 0);

        $query = $this->select(
            'dl.patientid',
            'dl.docid',
            DB::raw("'ledger_paid'"),
            'dl.ledgerid',
            'dl.service_date',
            'dl.entry_date',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name)"),
            'dl.description',
            'dl.amount',
            'dl.paid_amount',
            'dl.status',
            'dl.primary_claim_id',
            DB::raw('IF(dl.primary_claim_id, di.mailed_date, dl.service_date)'),
            'tc.type',
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw("''"),
            DB::raw('0 AS filed_by_bo')
        )->from(DB::raw('dental_ledger dl'))
        ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
        ->leftJoin(DB::raw('dental_ledger_payment pay'), 'pay.ledgerid', '=', 'dl.ledgerid')
        ->leftJoin(DB::raw('dental_insurance di'), 'di.insuranceid', '=', 'dl.primary_claim_id')
        ->leftJoin(DB::raw('dental_transaction_code tc'), function ($query) use ($data) {
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

    public function getWithFilter($fields = [], $where = [])
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

    private function getSortColumnForList($sort)
    {
        $sortColumns = [
            'entry_date'  => 'entry_date',
            'producer'    => 'name',
            'patient'     => 'lastname',
            'description' => 'description',
            'amount'      => 'amount',
            'paid_amount' => 'paid_amount',
            'status'      => 'status'
        ];

        if (array_key_exists($sort, $sortColumns)) {
            $sortColumn = $sortColumns[$sort];
        } else {
            $sortColumn = 'service_date';
        }

        return $sortColumn;
    }
}
