<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Charge as Resource;
use DentalSleepSolutions\Contracts\Repositories\Charges as Repository;

class Charge extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'userid', 'adminid',
        'charge_date', 'stripe_customer', 'stripe_charge',
        'stripe_card_fingerprint', 'adddate', 'ip_address',
        'invoice_id', 'status'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_charge';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
