<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Intolerance",
 *     type="object",
 *     required={"intoleranceid", "ip_address"},
 *     @SWG\Property(property="intoleranceid", type="integer"),
 *     @SWG\Property(property="intolerance", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Intolerance
 *
 * @property int $intoleranceid
 * @property string|null $intolerance
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @mixin \Eloquent
 */
class Intolerance extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'intolerance',
        'description',
        'sortby',
        'status',
        'adddate',
        'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_intolerance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'intoleranceid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
