<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ClaimElectronic as Resource;
use DentalSleepSolutions\Contracts\Repositories\ClaimsElectronic as Repository;

class ClaimElectronic extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid', 'response', 'adddate',
        'ip_address', 'reference_id', 'percase_date',
        'percase_name', 'percase_amount', 'percase_status',
        'percase_invoice', 'percase_free'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_claim_electronic';

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
