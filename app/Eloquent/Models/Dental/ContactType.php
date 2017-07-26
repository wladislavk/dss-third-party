<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="ContactType",
 *     type="object",
 *     required={"contacttypeid", "ip_address"},
 *     @SWG\Property(property="contacttypeid", type="integer"),
 *     @SWG\Property(property="contacttype", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="physician", type="integer"),
 *     @SWG\Property(property="corporate", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ContactType
 *
 * @property int $contacttypeid
 * @property string|null $contacttype
 * @property string|null $description
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string $ip_address
 * @property int|null $physician
 * @property int|null $corporate
 * @mixin \Eloquent
 */
class ContactType extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'contacttype',
        'description',
        'sortby',
        'status',
        'adddate',
        'ip_address',
        'physician',
        'corporate',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_contacttype';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'contacttypeid';

    const CREATED_AT = 'adddate';
}
