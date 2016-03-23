<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsuranceStatusHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsuranceStatusHistories as Repository;

class InsuranceStatusHistory extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'insuranceid', 'status', 'userid', 'adddate', 'ip_address', 'adminid'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance_status_history';

    /**
     * The primary key for the model.
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
