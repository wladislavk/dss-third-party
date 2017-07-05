<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\TmjClinicalExam as Resource;
use DentalSleepSolutions\Contracts\Repositories\TmjClinicalExams as Repository;

/**
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
 * @property string|null $dentaldevice_date
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdditionalParagraphPal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdditionalParagraphRm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionRL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDentaldevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDentaldeviceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationRL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereExPage5id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereJointExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereJointid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereOtherRangeMotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePalpationRid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePalpationid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralEqual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRangeNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereScreeningAware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereScreeningNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereUserid($value)
 * @mixin \Eloquent
 */
class TmjClinicalExam extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['ex_page5id', 'formid', 'patientid', 'palpationid', 'palpationRid',
        'additional_paragraph_pal', 'joint_exam', 'jointid', 'i_opening_from', 'i_opening_to', 'i_opening_equal',
        'protrusion_from', 'protrusion_to', 'protrusion_equal', 'l_lateral_from', 'l_lateral_to', 'l_lateral_equal',
        'r_lateral_from', 'r_lateral_to', 'r_lateral_equal', 'deviation_from', 'deviation_to', 'deviation_equal',
        'deflection_from', 'deflection_to', 'deflection_equal', 'range_normal', 'normal', 'other_range_motion',
        'additional_paragraph_rm', 'screening_aware', 'screening_normal', 'userid', 'docid', 'status', 'adddate',
        'ip_address', 'deviation_r_l', 'deflection_r_l', 'dentaldevice', 'dentaldevice_date',
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
