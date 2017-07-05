<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\CustomText as Resource;
use DentalSleepSolutions\Contracts\Repositories\CustomTexts as Repository;

/**
 * @SWG\Definition(
 *     definition="CustomText",
 *     type="object",
 *     required={"customid"},
 *     @SWG\Property(property="customid", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="default", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\CustomText
 *
 * @property int $customid
 * @property string|null $title
 * @property string|null $description
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $default_text
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereCustomid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDefaultText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereTitle($value)
 * @mixin \Eloquent
 */
class CustomText extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'docid', 'status',
        'adddate', 'ip_address', 'default_text'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_custom';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'customid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
