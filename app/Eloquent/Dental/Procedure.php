<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;

/**
 * DentalSleepSolutions\Eloquent\Dental\Procedure
 *
 * @property int $procedureid
 * @property int|null $patientid
 * @property int|null $insuranceid
 * @property string|null $service_date_from
 * @property string|null $service_date_to
 * @property string|null $place_service
 * @property string|null $type_service
 * @property string|null $cpt_code
 * @property string|null $units
 * @property string|null $charge
 * @property string|null $total_charge
 * @property string|null $applies_icd
 * @property string|null $npi
 * @property string|null $other_id
 * @property string|null $other_id_qualifier
 * @property string|null $modifier_code_1
 * @property string|null $modifier_code_2
 * @property string|null $modifier_code_3
 * @property string|null $modifier_code_4
 * @property string|null $epsdt
 * @property string|null $emg
 * @property string|null $supplemental_info
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereAppliesIcd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereCptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereEmg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereEpsdt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereInsuranceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereOtherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereOtherIdQualifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure wherePlaceService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereProcedureid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereServiceDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereServiceDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereSupplementalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereTotalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereTypeService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereUnits($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="Procedure",
 *     type="object",
 *     required={"procedureid"},
 *     @SWG\Property(property="procedureid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="insuranceid", type="integer"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="place", type="string"),
 *     @SWG\Property(property="type", type="string"),
 *     @SWG\Property(property="cpt", type="string"),
 *     @SWG\Property(property="units", type="string"),
 *     @SWG\Property(property="charge", type="string"),
 *     @SWG\Property(property="total", type="string"),
 *     @SWG\Property(property="applies", type="string"),
 *     @SWG\Property(property="npi", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="epsdt", type="string"),
 *     @SWG\Property(property="emg", type="string"),
 *     @SWG\Property(property="supplemental", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="Procedure",
 *     type="object",
 * 
 * )
 */
class Procedure extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['procedureid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_procedure';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'procedureid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
