<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="AssessmentPlanExam",
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
 *     @SWG\Property(property="assessment_codes", type="array"),
 *     @SWG\Property(property="assessment_description", type="string"),
 *     @SWG\Property(property="treatment_codes", type="array"),
 *     @SWG\Property(property="treatment_description", type="string"),
 *     @SWG\Property(property="created_at", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\AssessmentPlanExam
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doc_id
 * @property int|null $created_by_user
 * @property int|null $created_by_admin
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property string|null $ip_address
 * @property array|null $assessment_codes
 * @property string|null $assessment_description
 * @property array|null $treatment_codes
 * @property string|null $treatment_description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AssessmentPlanExam extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'assessment_codes',
        'assessment_description',
        'treatment_codes',
        'treatment_description',
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
    protected $table = 'dental_assessment_plan_exams';

    /**
     * @return array|null
     */
    public function getAssessmentCodesAttribute()
    {
        return json_decode($this->getAttributeFromArray('assessment_codes'), true);
    }

    /**
     * @param array $value
     */
    public function setAssessmentCodesAttribute(array $value = null)
    {
        $this->attributes['assessment_codes'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getTreatmentCodesAttribute()
    {
        return json_decode($this->getAttributeFromArray('treatment_codes'), true);
    }

    /**
     * @param array $value
     */
    public function setTreatmentCodesAttribute(array $value = null)
    {
        $this->attributes['treatment_codes'] = json_encode($value);
    }
}
