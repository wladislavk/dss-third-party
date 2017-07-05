<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\DentalClinicalExam as Resource;
use DentalSleepSolutions\Contracts\Repositories\DentalClinicalExams as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam
 *
 * @property int $ex_page4id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $exam_teeth
 * @property string|null $other_exam_teeth
 * @property string|null $caries
 * @property string|null $where_facets
 * @property string|null $cracked_fractured
 * @property string|null $old_worn_inadequate_restorations
 * @property string|null $dental_class_right
 * @property string|null $dental_division_right
 * @property string|null $dental_class_left
 * @property string|null $dental_division_left
 * @property string|null $additional_paragraph
 * @property string|null $initial_tooth
 * @property string|null $open_proximal
 * @property string|null $deistema
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $missing
 * @property string|null $crossbite
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCaries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCrackedFractured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCrossbite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDeistema($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalClassLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalClassRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalDivisionLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalDivisionRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereExPage4id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereExamTeeth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereInitialTooth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereMissing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOldWornInadequateRestorations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOpenProximal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOtherExamTeeth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereWhereFacets($value)
 * @mixin \Eloquent
 */
class DentalClinicalExam extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid', 'patientid', 'exam_teeth', 'other_exam_teeth', 'caries',
        'where_facets', 'cracked_fractured', 'old_worn_inadequate_restorations',
        'dental_class_right', 'dental_division_right', 'dental_class_left',
        'dental_division_left', 'additional_paragraph', 'initial_tooth',
        'open_proximal', 'deistema', 'userid', 'docid', 'status', 'adddate',
        'ip_address', 'missing', 'crossbite'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page4';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page4id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
