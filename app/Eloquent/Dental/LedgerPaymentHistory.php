<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerPaymentHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerPaymentHistories as Repository;

class LedgerPaymentHistory extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'paymentid', 'payer', 'amount', 'payment_type',
        'payment_date', 'entry_date', 'ledgerid', 'allowed',
        'ins_paid', 'deductible', 'copay', 'coins',
        'overpaid', 'followup', 'note', 'amount_allowed',
        'updated_by_user', 'updated_by_admin', 'updated_at'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_payment_history';

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
    protected $dates = ['payment_date', 'entry_date', 'followup'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'updated_at';

}
