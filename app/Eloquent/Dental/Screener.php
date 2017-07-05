<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Screener as Resource;
use DentalSleepSolutions\Contracts\Repositories\Screeners as Repository;

/**
 * @SWG\Definition(
 *     definition="Screener",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="first", type="string"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="epworth", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="breathing", type="integer"),
 *     @SWG\Property(property="driving", type="integer"),
 *     @SWG\Property(property="gasping", type="integer"),
 *     @SWG\Property(property="sleepy", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="weight", type="integer"),
 *     @SWG\Property(property="blood", type="integer"),
 *     @SWG\Property(property="jerk", type="integer"),
 *     @SWG\Property(property="burning", type="integer"),
 *     @SWG\Property(property="headaches", type="integer"),
 *     @SWG\Property(property="falling", type="integer"),
 *     @SWG\Property(property="staying", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="contacted", type="integer"),
 *     @SWG\Property(property="patient", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer"),
 *     @SWG\Property(property="rx", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Screener
 *
 * @property int $id
 * @property int|null $docid
 * @property int|null $userid
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property int|null $epworth_reading
 * @property int|null $epworth_public
 * @property int|null $epworth_passenger
 * @property int|null $epworth_lying
 * @property int|null $epworth_talking
 * @property int|null $epworth_lunch
 * @property int|null $epworth_traffic
 * @property int|null $snore_1
 * @property int|null $snore_2
 * @property int|null $snore_3
 * @property int|null $snore_4
 * @property int|null $snore_5
 * @property int|null $breathing
 * @property int|null $driving
 * @property int|null $gasping
 * @property int|null $sleepy
 * @property int|null $snore
 * @property int|null $weight_gain
 * @property int|null $blood_pressure
 * @property int|null $jerk
 * @property int|null $burning
 * @property int|null $headaches
 * @property int|null $falling_asleep
 * @property int|null $staying_asleep
 * @property int|null $rx_blood_pressure
 * @property int|null $rx_hypertension
 * @property int|null $rx_heart_disease
 * @property int|null $rx_stroke
 * @property int|null $rx_apnea
 * @property int|null $rx_diabetes
 * @property int|null $rx_lung_disease
 * @property int|null $rx_insomnia
 * @property int|null $rx_depression
 * @property int|null $rx_narcolepsy
 * @property int|null $rx_medication
 * @property int|null $rx_restless_leg
 * @property int|null $rx_headaches
 * @property int|null $rx_heartburn
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $rx_cpap
 * @property string|null $phone
 * @property int|null $contacted
 * @property int|null $patient_id
 * @property int|null $rx_metabolic_syndrome
 * @property int|null $rx_obesity
 * @property int|null $rx_afib
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBloodPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBreathing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBurning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereContacted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereDriving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthLunch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthLying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthPassenger($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthReading($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthTalking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthTraffic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereFallingAsleep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereGasping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereHeadaches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereJerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxAfib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxApnea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxBloodPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxCpap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxDepression($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxDiabetes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeadaches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeartDisease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeartburn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHypertension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxInsomnia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxLungDisease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxMetabolicSyndrome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxNarcolepsy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxObesity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxRestlessLeg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxStroke($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSleepy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereStayingAsleep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereWeightGain($value)
 * @mixin \Eloquent
 */
class Screener extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_screener';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
