<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="Calendar",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="start_date", type="string"),
 *     @SWG\Property(property="end_date", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="event_id", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="category", type="string"),
 *     @SWG\Property(property="producer_id", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="rec_type", type="string"),
 *     @SWG\Property(property="event_length", type="integer"),
 *     @SWG\Property(property="event_pid", type="integer"),
 *     @SWG\Property(property="res_id", type="integer"),
 *     @SWG\Property(property="rec_pattern", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Calendar
 *
 * @property int $id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $description
 * @property int|null $event_id
 * @property int|null $docid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $category
 * @property int|null $producer_id
 * @property int|null $patientid
 * @property string|null $rec_type
 * @property int|null $event_length
 * @property int|null $event_pid
 * @property int|null $res_id
 * @property string|null $rec_pattern
 * @mixin \Eloquent
 */
class Calendar extends AbstractModel implements Resource
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'start_date', 'end_date', 'description',
        'event_id', 'docid', 'adddate',
        'ip_address', 'category', 'producer_id',
        'patientid', 'rec_type', 'event_length',
        'event_pid', 'res_id', 'rec_pattern'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_calendar';

    /**
     * Primary key for the table
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
