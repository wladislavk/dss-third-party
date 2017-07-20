<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="Symptom",
 *     type="object",
 *     required={"q_page1id", "sleep_qual"},
 *     @SWG\Property(property="q_page1id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="member_no", type="string"),
 *     @SWG\Property(property="group_no", type="string"),
 *     @SWG\Property(property="plan_no", type="string"),
 *     @SWG\Property(property="primary_care_physician", type="string"),
 *     @SWG\Property(property="feet", type="string"),
 *     @SWG\Property(property="inches", type="string"),
 *     @SWG\Property(property="weight", type="string"),
 *     @SWG\Property(property="bmi", type="string"),
 *     @SWG\Property(property="sleep_qual", type="string"),
 *     @SWG\Property(property="complaintid", type="string"),
 *     @SWG\Property(property="other_complaint", type="string"),
 *     @SWG\Property(property="additional_paragraph", type="string"),
 *     @SWG\Property(property="energy_level", type="string"),
 *     @SWG\Property(property="snoring_sound", type="string"),
 *     @SWG\Property(property="wake_night", type="string"),
 *     @SWG\Property(property="breathing_night", type="string"),
 *     @SWG\Property(property="morning_headaches", type="string"),
 *     @SWG\Property(property="hours_sleep", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="quit_breathing", type="string"),
 *     @SWG\Property(property="bed_time_partner", type="string"),
 *     @SWG\Property(property="sleep_same_room", type="string"),
 *     @SWG\Property(property="told_you_snore", type="string"),
 *     @SWG\Property(property="main_reason", type="string"),
 *     @SWG\Property(property="main_reason_other", type="string"),
 *     @SWG\Property(property="exam_date", type="string", format="dateTime"),
 *     @SWG\Property(property="chief_complaint_text", type="string"),
 *     @SWG\Property(property="tss", type="string"),
 *     @SWG\Property(property="ess", type="string"),
 *     @SWG\Property(property="parent_patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Symptom
 *
 * @property int $q_page1id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $member_no
 * @property string|null $group_no
 * @property string|null $plan_no
 * @property string|null $primary_care_physician
 * @property string|null $feet
 * @property string|null $inches
 * @property string|null $weight
 * @property string|null $bmi
 * @property string $sleep_qual
 * @property string|null $complaintid
 * @property string|null $other_complaint
 * @property string|null $additional_paragraph
 * @property string|null $energy_level
 * @property string|null $snoring_sound
 * @property string|null $wake_night
 * @property string|null $breathing_night
 * @property string|null $morning_headaches
 * @property string|null $hours_sleep
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $quit_breathing
 * @property string|null $bed_time_partner
 * @property string|null $sleep_same_room
 * @property string|null $told_you_snore
 * @property string|null $main_reason
 * @property string|null $main_reason_other
 * @property \Carbon\Carbon|null $exam_date
 * @property string|null $chief_complaint_text
 * @property string|null $tss
 * @property string|null $ess
 * @property int|null $parent_patientid
 * @mixin \Eloquent
 */
class Symptom extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_page1id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_page1';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_page1id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['exam_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
