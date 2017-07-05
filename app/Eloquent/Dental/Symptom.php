<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Symptom as Resource;
use DentalSleepSolutions\Contracts\Repositories\Symptoms as Repository;

/**
 * @SWG\Definition(
 *     definition="Symptom",
 *     type="object",
 *     required={"q", "sleep"},
 *     @SWG\Property(property="q", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="member", type="string"),
 *     @SWG\Property(property="group", type="string"),
 *     @SWG\Property(property="plan", type="string"),
 *     @SWG\Property(property="primary", type="string"),
 *     @SWG\Property(property="feet", type="string"),
 *     @SWG\Property(property="inches", type="string"),
 *     @SWG\Property(property="weight", type="string"),
 *     @SWG\Property(property="bmi", type="string"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="complaintid", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="additional", type="string"),
 *     @SWG\Property(property="energy", type="string"),
 *     @SWG\Property(property="snoring", type="string"),
 *     @SWG\Property(property="wake", type="string"),
 *     @SWG\Property(property="breathing", type="string"),
 *     @SWG\Property(property="morning", type="string"),
 *     @SWG\Property(property="hours", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="quit", type="string"),
 *     @SWG\Property(property="bed", type="string"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="told", type="string"),
 *     @SWG\Property(property="main", type="string"),
 *     @SWG\Property(property="main", type="string"),
 *     @SWG\Property(property="exam", type="string", format="dateTime"),
 *     @SWG\Property(property="chief", type="string"),
 *     @SWG\Property(property="tss", type="string"),
 *     @SWG\Property(property="ess", type="string"),
 *     @SWG\Property(property="parent", type="integer")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBedTimePartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBreathingNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereChiefComplaintText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereComplaintid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereEnergyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereEss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereFeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereGroupNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereHoursSleep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereInches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMainReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMainReasonOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMemberNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMorningHeadaches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereOtherComplaint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereParentPatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePlanNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePrimaryCarePhysician($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereQPage1id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereQuitBreathing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSleepQual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSleepSameRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSnoringSound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereToldYouSnore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereTss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereWakeNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereWeight($value)
 * @mixin \Eloquent
 */
class Symptom extends AbstractModel implements Resource, Repository
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
