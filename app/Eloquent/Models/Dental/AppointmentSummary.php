<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="AppointmentSummary",
 *     type="object",
 *     required={"id, patientid, stepid, segmentid, date_scheduled, date_completed, appointment_type"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="stepid", type="integer"),
 *     @SWG\Property(property="segmentid", type="integer"),
 *     @SWG\Property(property="date_scheduled", type="string", format="date"),
 *     @SWG\Property(property="date_completed", type="string", format="date"),
 *     @SWG\Property(property="delay_reason", type="string"),
 *     @SWG\Property(property="study_type", type="string"),
 *     @SWG\Property(property="letterid", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="noncomp_reason", type="string"),
 *     @SWG\Property(property="device_date", type="string", format="date"),
 *     @SWG\Property(property="appointment_type", type="integer"),
 *     @SWG\Property(property="device_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\AppointmentSummary
 *
 * @property int $id
 * @property int $patientid
 * @property int $segmentid
 * @property string $date_scheduled
 * @property string $date_completed
 * @property string|null $delay_reason
 * @property string|null $study_type
 * @property string|null $letterid
 * @property string|null $description
 * @property string|null $noncomp_reason
 * @property string|null $device_date
 * @property int $appointment_type
 * @property int|null $device_id
 * @mixin \Eloquent
 */
class AppointmentSummary extends AbstractModel
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_flow_pg2_info';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_scheduled',
        'date_completed',
        'device_date',
    ];
}
