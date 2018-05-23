<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="PainTmdExam",
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
 *         property="description",
 *         type="object",
 *         @SWG\Property(property="chief_complaint", type="string"),
 *         @SWG\Property(property="extra_info", type="string"),
 *         @SWG\Property(
 *             property="pain",
 *             type="object",
 *             @SWG\Property(property="ease", type="string"),
 *             @SWG\Property(property="worse", type="string")
 *         ),
 *         @SWG\Property(property="treatment_goals", type="string")
 *     ),
 *     @SWG\Property(
 *         property="pain",
 *         type="object",
 *         @SWG\Property(
 *             property="back",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="upper",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="middle",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="lower",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="jaw",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="joint",
 *                 type="object",
 *                 @SWG\Property(
 *                     property="general",
 *                     type="object",
 *                     @SWG\Property(property="level", type="integer")
 *                 ),
 *                 @SWG\Property(
 *                     property="opening",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string"),
 *                     @SWG\Property(property="level", type="integer")
 *                 ),
 *                 @SWG\Property(
 *                     property="chewing",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string"),
 *                     @SWG\Property(property="level", type="integer")
 *                 ),
 *                 @SWG\Property(
 *                     property="at_rest",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string"),
 *                     @SWG\Property(property="level", type="integer")
 *                 )
 *             )
 *         ),
 *         @SWG\Property(
 *             property="eyes",
 *             type="object",
 *             @SWG\Property(
 *                 property="behind",
 *                 type="object",
 *                 @SWG\Property(property="checked", type="boolean"),
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="watery",
 *                 type="object",
 *                 @SWG\Property(property="checked", type="boolean"),
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="visual_disturbance",
 *                 type="object",
 *                 @SWG\Property(property="checked", type="boolean"),
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="ears",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="behind",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="front",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="ringing",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="throat",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="level", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="swallowing",
 *                 type="object",
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         )
 *         @SWG\Property(
 *             property="face",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="neck",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="shoulder",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="teeth",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string"),
 *                 @SWG\Property(property="level", type="integer")
 *             )
 *         )
 *     ),
 *     @SWG\Property(
 *         property="symptom_review",
 *         type="object",
 *         @SWG\Property(property="onset_of_event", type="string"),
 *         @SWG\Property(property="provocation", type="string"),
 *         @SWG\Property(property="quality_of_pain", type="string"),
 *         @SWG\Property(property="region_and_radiation", type="string"),
 *         @SWG\Property(property="severity", type="string"),
 *         @SWG\Property(property="time", type="string")
 *     ),
 *     @SWG\Property(
 *         property="symptoms",
 *         type="object",
 *         @SWG\Property(
 *             property="jaw",
 *             type="object",
 *             @SWG\Property(
 *                 property="locks",
 *                 type="object",
 *                 @SWG\Property(property="open", type="boolean"),
 *                 @SWG\Property(property="closed", type="boolean")
 *             ),
 *             @SWG\Property(
 *                 property="opening",
 *                 type="object",
 *                 @SWG\Property(property="clicks_pops", type="boolean"),
 *                 @SWG\Property(property="position", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="closing",
 *                 type="object",
 *                 @SWG\Property(property="clicks_pops", type="boolean"),
 *                 @SWG\Property(property="position", type="string")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="clenching",
 *             type="object",
 *             @SWG\Property(property="daytime", type="boolean"),
 *             @SWG\Property(property="nighttime", type="boolean")
 *         ),
 *         @SWG\Property(
 *             property="mouth",
 *             type="object",
 *             @SWG\Property(property="limited_opening", type="boolean")
 *         ),
 *         @SWG\Property(
 *             property="grinding",
 *             type="object",
 *             @SWG\Property(property="daytime", type="boolean"),
 *             @SWG\Property(property="nighttime", type="boolean")
 *         ),
 *         @SWG\Property(property="muscle_twitching", type="boolean"),
 *         @SWG\Property(
 *             property="numbness",
 *             type="object",
 *             @SWG\Property(property="lip", type="boolean"),
 *             @SWG\Property(property="jawbone", type="boolean")
 *         ),
 *         @SWG\Property(
 *             property="other",
 *             type="object",
 *             @SWG\Property(property="dry_mouth", type="boolean"),
 *             @SWG\Property(property="cheek_biting", type="boolean"),
 *             @SWG\Property(property="burning_tongue", type="boolean"),
 *             @SWG\Property(property="dizziness", type="boolean"),
 *             @SWG\Property(property="buzzing", type="boolean"),
 *             @SWG\Property(property="swallowing", type="boolean"),
 *             @SWG\Property(property="neck_stiffness", type="boolean"),
 *             @SWG\Property(property="vision_changes", type="boolean"),
 *             @SWG\Property(property="sciatica", type="boolean"),
 *             @SWG\Property(property="ear_infections", type="boolean"),
 *             @SWG\Property(property="foreign_feeling", type="boolean"),
 *             @SWG\Property(property="shoulder_stiffness", type="boolean"),
 *             @SWG\Property(property="blurred_vision", type="string"),
 *             @SWG\Property(property="fingers_tingling", type="boolean"),
 *             @SWG\Property(property="ear_congestion", type="boolean"),
 *             @SWG\Property(property="neck_swelling", type="boolean"),
 *             @SWG\Property(property="scoliosis", type="boolean"),
 *             @SWG\Property(property="visual_disturbances", type="boolean"),
 *             @SWG\Property(property="finger_hand_numbness", type="boolean"),
 *             @SWG\Property(property="hearing_loss", type="boolean"),
 *             @SWG\Property(property="gland_swelling", type="boolean"),
 *             @SWG\Property(property="chronic_sinusitis", type="boolean"),
 *             @SWG\Property(property="thyroid_swelling", type="boolean"),
 *             @SWG\Property(property="difficult_breathing", type="boolean"),
 *             @SWG\Property(property="description", type="string")
 *         )
 *     ),
 *     @SWG\Property(
 *         property="headaches",
 *         type="object",
 *         @SWG\Property(property="checked", type="boolean"),
 *         @SWG\Property(
 *             property="front",
 *             type="object",
 *             @SWG\Property(property="frequency", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="level", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="top",
 *             type="object",
 *             @SWG\Property(property="frequency", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="level", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="back",
 *             type="object",
 *             @SWG\Property(property="frequency", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="level", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="temple",
 *             type="object",
 *             @SWG\Property(property="position", type="string"),
 *             @SWG\Property(property="frequency", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="level", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="eyes",
 *             type="object",
 *             @SWG\Property(property="position", type="string"),
 *             @SWG\Property(property="frequency", type="string"),
 *             @SWG\Property(property="duration", type="string"),
 *             @SWG\Property(property="level", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="symptoms",
 *             type="object",
 *             @SWG\Property(property="dizziness", type="boolean"),
 *             @SWG\Property(property="noise_sensitivity", type="boolean"),
 *             @SWG\Property(property="throbbling", type="boolean"),
 *             @SWG\Property(property="double_vision", type="boolean"),
 *             @SWG\Property(property="light_sensitivity", type="boolean"),
 *             @SWG\Property(property="vomiting", type="boolean"),
 *             @SWG\Property(property="fatigue", type="boolean"),
 *             @SWG\Property(property="nausea", type="boolean"),
 *             @SWG\Property(property="eye_nose_running", type="boolean"),
 *             @SWG\Property(property="sinus_congestion", type="boolean"),
 *             @SWG\Property(property="burning", type="boolean"),
 *             @SWG\Property(
 *                 property="other",
 *                 type="object",
 *                 @SWG\Property(property="checked", type="boolean"),
 *                 @SWG\Property(property="details", type="string")
 *             ),
 *             @SWG\Property(property="dull_aching", type="boolean")
 *         ),
 *         @SWG\Property(
 *             property="migraines",
 *             type="object",
 *             @SWG\Property(property="checked", type="boolean"),
 *             @SWG\Property(property="specialist", type="string"),
 *             @SWG\Property(property="occurrence", type="string")
 *         )
 *     ),
 *     @SWG\Property(property="created_at", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PainTmdExam
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doc_id
 * @property int|null $created_by_user
 * @property int|null $created_by_admin
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property string|null $ip_address
 * @property array|null $description
 * @property array|null $pain
 * @property array|null $symptom_review
 * @property array|null $symptoms
 * @property array|null $headaches
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class PainTmdExam extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'pain',
        'symptom_review',
        'symptoms',
        'headaches',
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
    protected $table = 'dental_pain_tmd_exams';

    /**
     * @return array|null
     */
    public function getDescriptionAttribute()
    {
        return json_decode($this->getAttributeFromArray('description'), true);
    }

    /**
     * @param array $value
     */
    public function setDescriptionAttribute(array $value = null)
    {
        $this->attributes['description'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getPainAttribute()
    {
        return json_decode($this->getAttributeFromArray('pain'), true);
    }

    /**
     * @param array $value
     */
    public function setPainAttribute(array $value = null)
    {
        $this->attributes['pain'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getSymptomReviewAttribute()
    {
        return json_decode($this->getAttributeFromArray('symptom_review'), true);
    }

    /**
     * @param array $value
     */
    public function setSymptomReviewAttribute(array $value = null)
    {
        $this->attributes['symptom_review'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getSymptomsAttribute()
    {
        return json_decode($this->getAttributeFromArray('symptoms'), true);
    }

    /**
     * @param array $value
     */
    public function setSymptomsAttribute(array $value = null)
    {
        $this->attributes['symptoms'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getHeadachesAttribute()
    {
        return json_decode($this->getAttributeFromArray('headaches'), true);
    }

    /**
     * @param array $value
     */
    public function setHeadachesAttribute(array $value = null)
    {
        $this->attributes['headaches'] = json_encode($value);
    }
}
