<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\PatientInsurance as Resource;
use DentalSleepSolutions\Contracts\Repositories\PatientInsurances as Repository;
use DB;

/**
 * DentalSleepSolutions\Eloquent\Dental\PatientInsurance
 *
 * @property int $id
 * @property int|null $patientid
 * @property int|null $insurancetype
 * @property string|null $company
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $email
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereInsurancetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereZip($value)
 * @mixin \Eloquent
 */
class PatientInsurance extends AbstractModel implements Resource, Repository
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

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(id) AS total'))
            ->from(DB::raw('dental_patient_insurance pi'))
            ->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'pi.patientid')
            ->where('p.docid', $docId)
            ->first();
    }
}
