<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\PatientInsurance as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientInsurances as Repository;
use DB;

class PatientInsurance extends Model implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patient_insurance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getCurrent($docId = 0, $patientId = 0)
    {
        return $this->from(DB::raw('dental_patient_insurance pi'))
            ->select(DB::raw('pi.*, p.firstname as patfirstname, p.lastname as patlastname'))
            ->join(DB::raw('dental_patients p'), 'pi.patientid', '=', 'p.patientid')
            ->where('p.docid', $docId)
            ->where('p.patientid', $patientId)
            ->get();
    }
}
