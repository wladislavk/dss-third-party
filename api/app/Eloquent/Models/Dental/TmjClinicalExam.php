<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="TmjClinicalExam",
 *     type="object",
 *     required={"ex_page5id"},
 *     @SWG\Property(property="ex_page5id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="palpationid", type="string"),
 *     @SWG\Property(property="palpationRid", type="string"),
 *     @SWG\Property(property="additional_paragraph_pal", type="string"),
 *     @SWG\Property(property="joint_exam", type="string"),
 *     @SWG\Property(property="jointid", type="string"),
 *     @SWG\Property(property="i_opening_from", type="string"),
 *     @SWG\Property(property="i_opening_to", type="string"),
 *     @SWG\Property(property="i_opening_equal", type="string"),
 *     @SWG\Property(property="protrusion_from", type="string"),
 *     @SWG\Property(property="protrusion_to", type="string"),
 *     @SWG\Property(property="protrusion_equal", type="string"),
 *     @SWG\Property(property="l_lateral_from", type="string"),
 *     @SWG\Property(property="l_lateral_to", type="string"),
 *     @SWG\Property(property="l_lateral_equal", type="string"),
 *     @SWG\Property(property="r_lateral_from", type="string"),
 *     @SWG\Property(property="r_lateral_to", type="string"),
 *     @SWG\Property(property="r_lateral_equal", type="string"),
 *     @SWG\Property(property="deviation_from", type="string"),
 *     @SWG\Property(property="deviation_to", type="string"),
 *     @SWG\Property(property="deviation_equal", type="string"),
 *     @SWG\Property(property="deflection_from", type="string"),
 *     @SWG\Property(property="deflection_to", type="string"),
 *     @SWG\Property(property="deflection_equal", type="string"),
 *     @SWG\Property(property="range_normal", type="string"),
 *     @SWG\Property(property="normal", type="string"),
 *     @SWG\Property(property="other_range_motion", type="string"),
 *     @SWG\Property(property="additional_paragraph_rm", type="string"),
 *     @SWG\Property(property="screening_aware", type="string"),
 *     @SWG\Property(property="screening_normal", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="deviation_r_l", type="string"),
 *     @SWG\Property(property="deflection_r_l", type="string"),
 *     @SWG\Property(property="dentaldevice", type="integer"),
 *     @SWG\Property(property="dentaldevice_date", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam
 *
 * @property int $ex_page5id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $palpationid
 * @property string|null $palpationRid
 * @property string|null $additional_paragraph_pal
 * @property string|null $joint_exam
 * @property string|null $jointid
 * @property string|null $i_opening_from
 * @property string|null $i_opening_to
 * @property string|null $i_opening_equal
 * @property string|null $protrusion_from
 * @property string|null $protrusion_to
 * @property string|null $protrusion_equal
 * @property string|null $l_lateral_from
 * @property string|null $l_lateral_to
 * @property string|null $l_lateral_equal
 * @property string|null $r_lateral_from
 * @property string|null $r_lateral_to
 * @property string|null $r_lateral_equal
 * @property string|null $deviation_from
 * @property string|null $deviation_to
 * @property string|null $deviation_equal
 * @property string|null $deflection_from
 * @property string|null $deflection_to
 * @property string|null $deflection_equal
 * @property string|null $range_normal
 * @property string|null $normal
 * @property string|null $other_range_motion
 * @property string|null $additional_paragraph_rm
 * @property string|null $screening_aware
 * @property string|null $screening_normal
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $deviation_r_l
 * @property string|null $deflection_r_l
 * @property int|null $dentaldevice
 * @property \DateTime|null $dentaldevice_date
 * @mixin \Eloquent
 */
class TmjClinicalExam extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'ex_page5id',
        'formid',
        'patientid',
        'palpationid',
        'palpationRid',
        'additional_paragraph_pal',
        'joint_exam',
        'jointid',
        'i_opening_from',
        'i_opening_to',
        'i_opening_equal',
        'protrusion_from',
        'protrusion_to',
        'protrusion_equal',
        'l_lateral_from',
        'l_lateral_to',
        'l_lateral_equal',
        'r_lateral_from',
        'r_lateral_to',
        'r_lateral_equal',
        'deviation_from',
        'deviation_to',
        'deviation_equal',
        'deflection_from',
        'deflection_to',
        'deflection_equal',
        'range_normal',
        'normal',
        'other_range_motion',
        'additional_paragraph_rm',
        'screening_aware',
        'screening_normal',
        'userid',
        'docid',
        'status',
        'adddate',
        'ip_address',
        'deviation_r_l',
        'deflection_r_l',
        'dentaldevice',
        'dentaldevice_date',
    ];

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['ex_page5id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page5';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page5id';

    const CREATED_AT = 'adddate';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'dentaldevice_date',
    ];
}
