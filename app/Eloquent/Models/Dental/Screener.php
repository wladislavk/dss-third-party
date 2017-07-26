<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Screener",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="first_name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="epworth_reading", type="integer"),
 *     @SWG\Property(property="epworth_public", type="integer"),
 *     @SWG\Property(property="epworth_passenger", type="integer"),
 *     @SWG\Property(property="epworth_lying", type="integer"),
 *     @SWG\Property(property="epworth_talking", type="integer"),
 *     @SWG\Property(property="epworth_lunch", type="integer"),
 *     @SWG\Property(property="epworth_traffic", type="integer"),
 *     @SWG\Property(property="snore_1", type="integer"),
 *     @SWG\Property(property="snore_2", type="integer"),
 *     @SWG\Property(property="snore_3", type="integer"),
 *     @SWG\Property(property="snore_4", type="integer"),
 *     @SWG\Property(property="snore_5", type="integer"),
 *     @SWG\Property(property="breathing", type="integer"),
 *     @SWG\Property(property="driving", type="integer"),
 *     @SWG\Property(property="gasping", type="integer"),
 *     @SWG\Property(property="sleepy", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="weight_gain", type="integer"),
 *     @SWG\Property(property="blood_pressure", type="integer"),
 *     @SWG\Property(property="jerk", type="integer"),
 *     @SWG\Property(property="burning", type="integer"),
 *     @SWG\Property(property="headaches", type="integer"),
 *     @SWG\Property(property="falling_asleep", type="integer"),
 *     @SWG\Property(property="staying_asleep", type="integer"),
 *     @SWG\Property(property="rx_blood_pressure", type="integer"),
 *     @SWG\Property(property="rx_hypertension", type="integer"),
 *     @SWG\Property(property="rx_heart_disease", type="integer"),
 *     @SWG\Property(property="rx_stroke", type="integer"),
 *     @SWG\Property(property="rx_apnea", type="integer"),
 *     @SWG\Property(property="rx_diabetes", type="integer"),
 *     @SWG\Property(property="rx_lung_disease", type="integer"),
 *     @SWG\Property(property="rx_insomnia", type="integer"),
 *     @SWG\Property(property="rx_depression", type="integer"),
 *     @SWG\Property(property="rx_narcolepsy", type="integer"),
 *     @SWG\Property(property="rx_medication", type="integer"),
 *     @SWG\Property(property="rx_restless_leg", type="integer"),
 *     @SWG\Property(property="rx_headaches", type="integer"),
 *     @SWG\Property(property="rx_heartburn", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="rx_cpap", type="integer"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="contacted", type="integer"),
 *     @SWG\Property(property="patient_id", type="integer"),
 *     @SWG\Property(property="rx_metabolic_syndrome", type="integer"),
 *     @SWG\Property(property="rx_obesity", type="integer"),
 *     @SWG\Property(property="rx_afib", type="integer")
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
 * @mixin \Eloquent
 */
class Screener extends AbstractModel
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

    const CREATED_AT = 'adddate';
}
