<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Qualifier",
 *     type="object",
 *     required={"qualifierid", "ip_address"},
 *     @SWG\Property(property="qualifierid", type="integer"),
 *     @SWG\Property(property="qualifier", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Qualifier
 *
 * @property int $qualifierid
 * @property string|null $qualifier
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @mixin \Eloquent
 */
class Qualifier extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['qualifierid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_qualifier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'qualifierid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
