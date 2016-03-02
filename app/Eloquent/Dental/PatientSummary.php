<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\PatientSummary as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientSummaries as Repository;

class PatientSummary extends Model implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'pid', 'fspage1_complete', 'next_visit',
        'last_visit', 'last_treatment', 'appliance',
        'delivery_date', 'vob', 'ledger', 'patient_info'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_summaries';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
