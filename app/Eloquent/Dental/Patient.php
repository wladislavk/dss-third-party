<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Patient as Resource;
use DentalSleepSolutions\Contracts\Repositories\Patients as Repository;

class Patient extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['patientid', 'password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'patientid';


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time', 'text_date', 'registration_senton',
        'access_code_date', 'new_fee_date'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * RELATIONS
     */
    public function tongueClinicalExam()
    {
        return $this->hasOne(TongueClinicalExam::class, 'patientid', 'patientid');
    }

    public function tonsilsClinicalExam()
    {
        return $this->hasOne(TonsilsClinicalExam::class, 'patientid', 'patientid');
    }

    public function airwayEvaluation()
    {
        return $this->hasOne(AirwayEvaluation::class, 'patientid', 'patientid');
    }

    public function dentalClinicalExam()
    {
        return $this->hasOne(DentalClinicalExam::class, 'patientid', 'patientid');
    }

    public function tmjClinicalExam()
    {
        return $this->hasOne(TmjClinicalExam::class, 'patientid', 'patientid');
    }

}
