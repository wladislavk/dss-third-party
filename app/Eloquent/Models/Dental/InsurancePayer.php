<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="InsurancePayer",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="payer_id", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsurancePayer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $payer_id
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class InsurancePayer extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'payer_id', 'adddate', 'ip_address'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ins_payer';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}
