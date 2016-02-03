<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\AirwayEvaluation as Resource;
use DentalSleepSolutions\Contracts\Repositories\AirwayEvaluations as Repository;

class AirwayEvaluation extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'maxilla', 'other_maxilla',
        'mandible', 'other_mandible', 'soft_palate', 'other_soft_palate',
        'uvula', 'other_uvula', 'gag_reflex', 'other_gag_reflex',
        'nasal_passages', 'other_nasal_passages', 'userid',
        'docid', 'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page3';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page3id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
