<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Intolerance as Resource;
use DentalSleepSolutions\Contracts\Repositories\Intolerances as Repository;

/**
 * @SWG\Definition(
 *     definition="Intolerance",
 *     type="object",
 *     required={"intoleranceid", "ip"},
 *     @SWG\Property(property="intoleranceid", type="integer"),
 *     @SWG\Property(property="intolerance", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIntolerance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIntoleranceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereStatus($value)
 * @mixin \Eloquent
 */
class Intolerance extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'intolerance', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
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
