<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PreviousTreatment as Resource;
use DentalSleepSolutions\Contracts\Repositories\PreviousTreatments as Repository;

/**
 * @SWG\Definition(
 *     definition="PreviousTreatment",
 *     type="object",
 *     required={"q", "triedquittried", "timesovertime"},
 *     @SWG\Property(property="q", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="polysomnographic", type="integer"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="confirmed", type="string"),
 *     @SWG\Property(property="rdi", type="string"),
 *     @SWG\Property(property="ahi", type="string"),
 *     @SWG\Property(property="cpap", type="string"),
 *     @SWG\Property(property="intolerance", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="affidavit", type="string"),
 *     @SWG\Property(property="type", type="string"),
 *     @SWG\Property(property="nights", type="string"),
 *     @SWG\Property(property="percent", type="string"),
 *     @SWG\Property(property="custom", type="string"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="triedquittried", type="string"),
 *     @SWG\Property(property="timesovertime", type="string"),
 *     @SWG\Property(property="cur", type="string"),
 *     @SWG\Property(property="sleep", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="dd", type="string"),
 *     @SWG\Property(property="surgery", type="string"),
 *     @SWG\Property(property="parent", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PreviousTreatment
 *
 * @property int $q_page2id
 * @property int|null $formid
 * @property int|null $patientid
 * @property int|null $polysomnographic
 * @property string|null $sleep_center_name
 * @property string|null $sleep_study_on
 * @property string|null $confirmed_diagnosis
 * @property string|null $rdi
 * @property string|null $ahi
 * @property string|null $cpap
 * @property string|null $intolerance
 * @property string|null $other_intolerance
 * @property string|null $other_therapy
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $other
 * @property string|null $affidavit
 * @property string|null $type_study
 * @property string|null $nights_wear_cpap
 * @property string|null $percent_night_cpap
 * @property string|null $custom_diagnosis
 * @property string|null $sleep_study_by
 * @property string $triedquittried
 * @property string $timesovertime
 * @property string|null $cur_cpap
 * @property string|null $sleep_center_name_text
 * @property string|null $dd_wearing
 * @property string|null $dd_prev
 * @property string|null $dd_otc
 * @property string|null $dd_fab
 * @property string|null $dd_who
 * @property string|null $dd_experience
 * @property string|null $surgery
 * @property int|null $parent_patientid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAffidavit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAhi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereConfirmedDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCurCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCustomDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdFab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdOtc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdPrev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdWearing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdWho($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereIntolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereNightsWearCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOtherIntolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOtherTherapy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereParentPatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePercentNightCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePolysomnographic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereQPage2id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereRdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepCenterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepCenterNameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepStudyBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepStudyOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTimesovertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTriedquittried($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTypeStudy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereUserid($value)
 * @mixin \Eloquent
 */
class PreviousTreatment extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_page2id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_page2';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_page2id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
