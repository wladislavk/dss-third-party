<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerHistories as Repository;

class LedgerHistory extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ledgerid', 'formid', 'patientid', 'service_date',
        'entry_date', 'description', 'producer', 'amount',
        'transaction_type', 'paid_amount', 'userid', 'docid',
        'status', 'adddate', 'ip_address', 'transaction_code',
        'placeofservice', 'emg', 'diagnosispointer', 'daysorunits',
        'epsdt', 'idqual', 'modcode', 'producerid', 'primary_claim_id',
        'primary_paper_claim_id', 'modcode2', 'modcode3', 'modcode4',
        'percase_date', 'percase_name', 'percase_amount','percase_status',
        'percase_invoice', 'percase_free', 'updated_by_user',
        'updated_by_admin', 'primary_claim_history_id', 'updated_at'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['percase_date', 'updated_at'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
