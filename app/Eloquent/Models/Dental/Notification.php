<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="Notification",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="notification", type="string"),
 *     @SWG\Property(property="notification_type", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="notification_date", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Notification
 *
 * @property int $id
 * @property int|null $patientid
 * @property int|null $docid
 * @property string|null $notification
 * @property string|null $notification_type
 * @property int|null $status
 * @property string|null $notification_date
 * @mixin \Eloquent
 */
class Notification extends AbstractModel
{
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
    protected $table = 'dental_notifications';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
