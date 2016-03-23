<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'dental_patients';
    protected $primaryKey = 'patientid';


    /**
     * RELATIONS
     */
    public function tongue()
    {
        return $this->hasOne(TongueClinicalExam::class, 'patientid', 'patientid');
    }

    public function tonsils()
    {
        return $this->hasOne(TonsilsClinicalExam::class, 'patientid', 'patientid');
    }
}
