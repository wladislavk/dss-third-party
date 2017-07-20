<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;

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
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="default_text", type="integer")
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
 * @mixin \Eloquent
 */
class CustomText extends AbstractModel implements Resource
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
