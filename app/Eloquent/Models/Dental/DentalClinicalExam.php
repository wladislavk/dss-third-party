<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="DentalClinicalExam",
 *     type="object",
 *     required={"ex_page4id"},
 *     @SWG\Property(property="ex_page4id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="exam_teeth", type="string"),
 *     @SWG\Property(property="other_exam_teeth", type="string"),
 *     @SWG\Property(property="caries", type="string"),
 *     @SWG\Property(property="where_facets", type="string"),
 *     @SWG\Property(property="cracked_fractured", type="string"),
 *     @SWG\Property(property="old_worn_inadequate_restorations", type="string"),
 *     @SWG\Property(property="dental_class_right", type="string"),
 *     @SWG\Property(property="dental_division_right", type="string"),
 *     @SWG\Property(property="dental_class_left", type="string"),
 *     @SWG\Property(property="dental_division_left", type="string"),
 *     @SWG\Property(property="additional_paragraph", type="string"),
 *     @SWG\Property(property="initial_tooth", type="string"),
 *     @SWG\Property(property="open_proximal", type="string"),
 *     @SWG\Property(property="deistema", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="missing", type="string"),
 *     @SWG\Property(property="crossbite", type="string")
 * )
 *
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
 * @mixin \Eloquent
 */
class DentalClinicalExam extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'formid',
        'patientid',
        'exam_teeth',
        'other_exam_teeth',
        'caries',
        'where_facets',
        'cracked_fractured',
        'old_worn_inadequate_restorations',
        'dental_class_right',
        'dental_division_right',
        'dental_class_left',
        'dental_division_left',
        'additional_paragraph',
        'initial_tooth',
        'open_proximal',
        'deistema',
        'userid',
        'docid',
        'status',
        'adddate',
        'ip_address',
        'missing',
        'crossbite',
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

    const CREATED_AT = 'adddate';
}
