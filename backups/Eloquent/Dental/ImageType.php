<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ImageType as Resource;
use DentalSleepSolutions\Contracts\Repositories\ImageTypes as Repository;

/**
 * @SWG\Definition(
 *     definition="ImageType",
 *     type="object",
 *     required={"imagetypeid", "ip_address"},
 *     @SWG\Property(property="imagetypeid", type="integer"),
 *     @SWG\Property(property="imagetype", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ImageType
 *
 * @property int $imagetypeid
 * @property string|null $imagetype
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereImagetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereImagetypeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereStatus($value)
 * @mixin \Eloquent
 */
class ImageType extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'imagetype', 'description', 'sortby',
        'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_imagetype';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'imagetypeid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
