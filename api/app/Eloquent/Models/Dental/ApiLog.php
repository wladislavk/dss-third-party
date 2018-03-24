<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="ApiLog",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="method", type="string"),
 *     @SWG\Property(property="route", type="string"),
 *     @SWG\Property(property="payload", type="string"),
 *     @SWG\Property(property="created_at", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ApiLog
 *
 * @property int $id
 * @property string|null $method
 * @property string|null $route
 * @property string|null $payload
 * @property \Carbon\Carbon|null $created_at
 * @mixin \Eloquent
 */
class ApiLog extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['method', 'route', 'payload'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_api_logs';

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
    public $timestamps = true;
}
