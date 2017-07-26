<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Allergen",
 *     type="object",
 *     required={"allergensid", "ip_address"},
 *     @SWG\Property(property="allergensid", type="integer"),
 *     @SWG\Property(property="allergens", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Allergen
 *
 * @property int $allergensid
 * @property string|null $allergens
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @mixin \Eloquent
 */
class Allergen extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'allergens',
        'description',
        'sortby',
        'status',
        'adddate',
        'ip_address',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_allergens';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'allergensid';

    const CREATED_AT = 'adddate';
}
