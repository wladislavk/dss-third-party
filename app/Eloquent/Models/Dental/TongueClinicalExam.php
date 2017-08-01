<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="TongueClinicalExam",
 *     type="object",
 *     required={"ex_page1id"},
 *     @SWG\Property(property="ex_page1id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="blood_pressure", type="string"),
 *     @SWG\Property(property="pulse", type="string"),
 *     @SWG\Property(property="neck_measurement", type="string"),
 *     @SWG\Property(property="bmi", type="string"),
 *     @SWG\Property(property="additional_paragraph", type="string"),
 *     @SWG\Property(property="tongue", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam
 *
 * @property int $ex_page1id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $blood_pressure
 * @property string|null $pulse
 * @property string|null $neck_measurement
 * @property string|null $bmi
 * @property string|null $additional_paragraph
 * @property string|null $tongue
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class TongueClinicalExam extends AbstractModel
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
        'blood_pressure',
        'pulse',
        'neck_measurement',
        'bmi',
        'additional_paragraph',
        'tongue',
        'userid',
        'docid',
        'status',
        'adddate',
        'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ex_page1';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ex_page1id';

    const CREATED_AT = 'adddate';
}
