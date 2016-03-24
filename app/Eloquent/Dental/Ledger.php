<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Ledger as Resource;
use DentalSleepSolutions\Contracts\Repositories\Ledgers as Repository;

class Ledger extends Model implements Resource, Repository
{
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
}
