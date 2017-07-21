<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="InsuranceFile",
 *     type="object",
 *     required={"id", "claimid"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="integer"),
 *     @SWG\Property(property="claimtype", type="string"),
 *     @SWG\Property(property="filename", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="status", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsuranceFile
 *
 * @property int $id
 * @property int $claimid
 * @property string|null $claimtype
 * @property string|null $filename
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $description
 * @property int|null $status
 * @mixin \Eloquent
 */
class InsuranceFile extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid',
        'claimtype',
        'filename',
        'adddate',
        'ip_address',
        'description',
        'status',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_insurance_file';

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
}
