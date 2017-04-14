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
        $resultList = $list->splice($page * $rowsPerPage, $rowsPerPage);

        return [
            'total'  => count($list),
            'result' => $resultList
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

    public function getTotalCharges($docId, $type = 'today')
    {
        if ($type == 'today') {
            $total = $this->select(DB::raw('SUM(dl.amount) AS total'))
                ->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
                ->where('dl.docid', $docId)
                ->where('dl.service_date', Carbon::now())
                ->where(function ($query) {
                    $query->whereNull('dl.paid_amount')
                        ->orWhere('dl.paid_amount', 0);
                })->groupBy('dl.ledgerid')
                ->first();

            return !empty($total) ? $total->total : 0;
        } else {
            return 0;
        }
    }

    public function getTotalCredits($docId, $type = 'today')
    {
        if ($type == 'today') {
            $total = $this->select(DB::raw('SUM(dlp.amount) AS total'))
                ->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
                ->leftJoin(DB::raw('dental_ledger_payment dlp'), 'dlp.ledgerid', '=', 'dl.ledgerid')
                ->where('dl.docid', $docId)
                ->where('dlp.amount', '!=', 0)
                ->where('dlp.payer', '!=', self::DSS_TRXN_TYPE_ADJ)
                ->where('dlp.payment_date', Carbon::now())
                ->first();
        } else {
            $total = $this->select(DB::raw('SUM(dl.paid_amount) AS total'))
                ->from(DB::raw('dental_ledger dl'))
                ->leftJoin(DB::raw('dental_users p'), 'dl.producerid', '=', 'p.userid')
                ->where('dl.docid', $docId)
                ->first();
        }

        return !empty($total) ? $total->total : 0;
    }

    public function getTotalAdjustments($docId, $type = 'today')
    {
        if ($type == 'today') {
            $total = $this->select(DB::raw('SUM(dl.paid_amount) AS total'))
                ->from(DB::raw('dental_ledger dl'))
                ->join(DB::raw('dental_patients AS pat'), 'dl.patientid', '=', 'pat.patientid')
                ->leftJoin(DB::raw('dental_users AS p'), 'dl.producerid', '=', 'p.userid')
                ->leftJoin(DB::raw('dental_transaction_code tc'), function ($query) use ($docId) {
                    $query->on('tc.transaction_code', '=', 'dl.transaction_code')
                        ->where('tc.docid', '=', $docId);
                })->where('dl.docid', $docId)
                ->where(function ($query) {
                    $query->whereNotNull('dl.paid_amount')
                        ->where('dl.paid_amount', '!=', 0);
                })->where('dl.service_date', Carbon::now())
                ->first();

            return !empty($total) ? $total->total : 0;
        } else {
            return 0;
        }
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
        $sortColumn = '';

        switch ($sort) {
            case 'producer':
                $sortColumn = 'name';
                break;

            case 'patient':
                $sortColumn = 'lastname';
                break;

            case 'paid_amount':
                $sortColumn = 'paid_amount';
                break;

            default:
                $sortColumn = 'service_date';
                break;
        }

        return $sortColumn;
    }
}
