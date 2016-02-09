<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\InsDiagnosis as Resource;
use DentalSleepSolutions\Contracts\Repositories\InsDiagnoses as Repository;

class InsDiagnosis extends Model
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ins_diagnosis', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ins_diagnosis';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'ins_diagnosisid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
