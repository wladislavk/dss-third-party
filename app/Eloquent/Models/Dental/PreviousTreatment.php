<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="PreviousTreatment",
 *     type="object",
 *     required={"q_page2id", "triedquittried", "timesovertime"},
 *     @SWG\Property(property="q_page2id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="polysomnographic", type="integer"),
 *     @SWG\Property(property="sleep_center_name", type="string"),
 *     @SWG\Property(property="sleep_study_on", type="string"),
 *     @SWG\Property(property="confirmed_diagnosis", type="string"),
 *     @SWG\Property(property="rdi", type="string"),
 *     @SWG\Property(property="ahi", type="string"),
 *     @SWG\Property(property="cpap", type="string"),
 *     @SWG\Property(property="intolerance", type="string"),
 *     @SWG\Property(property="other_intolerance", type="string"),
 *     @SWG\Property(property="other_therapy", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="other", type="string"),
 *     @SWG\Property(property="affidavit", type="string"),
 *     @SWG\Property(property="type_study", type="string"),
 *     @SWG\Property(property="nights_wear_cpap", type="string"),
 *     @SWG\Property(property="percent_night_cpap", type="string"),
 *     @SWG\Property(property="custom_diagnosis", type="string"),
 *     @SWG\Property(property="sleep_study_by", type="string"),
 *     @SWG\Property(property="triedquittried", type="string"),
 *     @SWG\Property(property="timesovertime", type="string"),
 *     @SWG\Property(property="cur_cpap", type="string"),
 *     @SWG\Property(property="sleep_center_name_text", type="string"),
 *     @SWG\Property(property="dd_wearing", type="string"),
 *     @SWG\Property(property="dd_prev", type="string"),
 *     @SWG\Property(property="dd_otc", type="string"),
 *     @SWG\Property(property="dd_fab", type="string"),
 *     @SWG\Property(property="dd_who", type="string"),
 *     @SWG\Property(property="dd_experience", type="string"),
 *     @SWG\Property(property="surgery", type="string"),
 *     @SWG\Property(property="parent_patientid", type="integer")
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
 * @mixin \Eloquent
 */
class PreviousTreatment extends AbstractModel
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

    const CREATED_AT = 'adddate';
}
