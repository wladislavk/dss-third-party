<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'dental_patients';
    protected $primaryKey = 'patientid';
}
