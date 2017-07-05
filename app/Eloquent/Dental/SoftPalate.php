<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\SoftPalate as Resource;
use DentalSleepSolutions\Contracts\Repositories\SoftPalates as Repository;

/**
 * @SWG\Definition(
 *     definition="SoftPalate",
 *     type="object",
 *     required={"soft", "ip"},
 *     @SWG\Property(property="soft", type="integer"),
 *     @SWG\Property(property="soft", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SoftPalate
 *
 * @property int $soft_palateid
 * @property string|null $soft_palate
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSoftPalate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSoftPalateid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereStatus($value)
 * @mixin \Eloquent
 */
class SoftPalate extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'soft_palate', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_soft_palate';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'soft_palateid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
