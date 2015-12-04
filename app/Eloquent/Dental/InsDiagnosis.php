<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class InsDiagnosis extends Model
{
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
}
