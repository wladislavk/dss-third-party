<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Complaint",
 *     type="object",
 *     required={"complaintid", "ip_address"},
 *     @SWG\Property(property="complaintid", type="integer"),
 *     @SWG\Property(property="complaint", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Complaint
 *
 * @property int $complaintid
 * @property string|null $complaint
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @mixin \Eloquent
 */
class Complaint extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'complaint',
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
    protected $table = 'dental_complaint';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'complaintid';

    const CREATED_AT = 'adddate';
}
