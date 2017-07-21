<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="ScreenerEpworth",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="screener_id", type="integer"),
 *     @SWG\Property(property="epworth_id", type="integer"),
 *     @SWG\Property(property="response", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth
 *
 * @property int $id
 * @property int|null $screener_id
 * @property int|null $epworth_id
 * @property int|null $response
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class ScreenerEpworth extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'screener_id',
        'epworth_id',
        'response',
        'adddate',
        'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_screener_epworth';

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

    public function getPlural()
    {
        return 'ScreenerEpworth';
    }
}
