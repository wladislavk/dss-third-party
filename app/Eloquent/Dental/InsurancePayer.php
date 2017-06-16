<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;

class InsurancePayer extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'payer_id', 'adddate', 'ip_address'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ins_payer';

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
