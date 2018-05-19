<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="EvaluationManagementExam",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patient_id", type="integer"),
 *     @SWG\Property(property="doc_id", type="integer"),
 *     @SWG\Property(property="created_by_user", type="integer"),
 *     @SWG\Property(property="created_by_admin", type="integer"),
 *     @SWG\Property(property="updated_by_user", type="integer"),
 *     @SWG\Property(property="updated_by_admin", type="integer"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(
 *         property="history",
 *         type="object",
 *         @SWG\Property(
 *             property="chief_complaint",
 *             type="object",
 *             @SWG\Property(property="value", type="string"),
 *             @SWG\Property(property="default", type="string")
 *         ),
 *         @SWG\Property(
 *             property="present",
 *             type="object",
 *             @SWG\Property(property="location", type="string"),
 *             @SWG\Property(property="quality", type="string"),
 *             @SWG\Property(property="severity", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="timing", type="string"),
 *             @SWG\Property(property="context", type="string"),
 *             @SWG\Property(property="modifying_factor", type="string"),
 *             @SWG\Property(property="symptoms", type="string")
 *         ),
 *         @SWG\Property(
 *             property="past",
 *             type="object",
 *             @SWG\Property(
 *                 property="family",
 *                 type="object",
 *                 @SWG\Property(property="value", type="string"),
 *                 @SWG\Property(property="default", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="medical",
 *                 type="object",
 *                 @SWG\Property(
 *                     property="allergens",
 *                     type="object",
 *                     @SWG\Property(property="value", type="string"),
 *                     @SWG\Property(property="default", type="string")
 *                 ),
 *                 @SWG\Property(
 *                     property="medication",
 *                     type="object",
 *                     @SWG\Property(property="value", type="string"),
 *                     @SWG\Property(property="default", type="string")
 *                 ),
 *                 @SWG\Property(
 *                     property="general",
 *                     type="object",
 *                     @SWG\Property(property="value", type="string"),
 *                     @SWG\Property(property="default", type="string")
 *                 ),
 *                 @SWG\Property(
 *                     property="dental",
 *                     type="object",
 *                     @SWG\Property(property="value", type="string"),
 *                     @SWG\Property(property="default", type="string")
 *                 )
 *             ),
 *             @SWG\Property(
 *                 property="social",
 *                 type="object",
 *                 @SWG\Property(property="value", type="string"),
 *                 @SWG\Property(property="default", type="string")
 *             )
 *         )
 *     ),
 *     @SWG\Property(
 *         property="systems",
 *         type="object",
 *         @SWG\Property(property="constitutional", type="string"),
 *         @SWG\Property(property="eyes", type="string"),
 *         @SWG\Property(property="ears_nose_mouth_throat", type="string"),
 *         @SWG\Property(property="cardiovascular", type="string"),
 *         @SWG\Property(property="respiratory", type="string"),
 *         @SWG\Property(property="gastrointestinal", type="string"),
 *         @SWG\Property(property="genitourinary", type="string"),
 *         @SWG\Property(property="musculoskeletal", type="string"),
 *         @SWG\Property(property="integumentary", type="string"),
 *         @SWG\Property(property="neurologic", type="string"),
 *         @SWG\Property(property="psychiatric", type="string"),
 *         @SWG\Property(property="endocrine", type="string"),
 *         @SWG\Property(property="hematologic_lymphatic", type="string"),
 *         @SWG\Property(property="allergic_immunologic", type="string")
 *     ),
 *     @SWG\Property(
 *         property="vital_signs",
 *         type="object",
 *         @SWG\Property(
 *             property="height",
 *             type="object",
 *             @SWG\Property(property="feet", type="integer"),
 *             @SWG\Property(property="inches", type="integer")
 *         ),
 *         @SWG\Property(property="weight", type="float"),
 *         @SWG\Property(property="bmi", type="float"),
 *         @SWG\Property(property="blood_pressure", type="integer"),
 *         @SWG\Property(property="pulse", type="integer"),
 *         @SWG\Property(property="neck_measurement", type="integer"),
 *         @SWG\Property(property="respirations", type="integer"),
 *         @SWG\Property(property="appearance", type="string"),
 *         @SWG\Property(property="orientation", type="string"),
 *         @SWG\Property(property="mood_affect", type="string"),
 *         @SWG\Property(property="gait_station", type="string"),
 *         @SWG\Property(property="coordination_balance", type="string"),
 *         @SWG\Property(property="sensation", type="string")
 *     ),
 *     @SWG\Property(
 *         property="body_area",
 *         type="object",
 *         @SWG\Property(property="first_description", type="string"),
 *         @SWG\Property(property="palpation", type="string"),
 *         @SWG\Property(property="rom", type="string"),
 *         @SWG\Property(property="stability", type="string"),
 *         @SWG\Property(property="strength", type="string"),
 *         @SWG\Property(property="skin", type="string"),
 *         @SWG\Property(property="second_description", type="string"),
 *         @SWG\Property(property="lips_teeth_gums", type="string"),
 *         @SWG\Property(property="oropharynx", type="string"),
 *         @SWG\Property(property="nasal_septum_turbinates", type="string")
 *     ),
 *     @SWG\Property(property="created_at", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\EvaluationManagementExam
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doc_id
 * @property int|null $created_by_user
 * @property int|null $created_by_admin
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property string|null $ip_address
 * @property array|null $history
 * @property array|null $systems
 * @property array|null $vital_signs
 * @property array|null $body_area
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class EvaluationManagementExam extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'history',
        'systems',
        'vital_signs',
        'body_area',
    ];

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_evaluation_management_exams';

    /**
     * @return array|null
     */
    public function getHistoryAttribute()
    {
        return json_decode($this->getAttributeFromArray('history'), true);
    }

    /**
     * @param array $value
     */
    public function setHistoryAttribute(array $value = null)
    {
        $this->attributes['history'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getSystemsAttribute()
    {
        return json_decode($this->getAttributeFromArray('systems'), true);
    }

    /**
     * @param array $value
     */
    public function setSystemsAttribute(array $value = null)
    {
        $this->attributes['systems'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getVitalSignsAttribute()
    {
        return json_decode($this->getAttributeFromArray('vital_signs'), true);
    }

    /**
     * @param array $value
     */
    public function setVitalSignsAttribute(array $value = null)
    {
        $this->attributes['vital_signs'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getBodyAreaAttribute()
    {
        return json_decode($this->getAttributeFromArray('body_area'), true);
    }

    /**
     * @param array $value
     */
    public function setBodyAreaAttribute(array $value = null)
    {
        $this->attributes['body_area'] = json_encode($value);
    }
}
