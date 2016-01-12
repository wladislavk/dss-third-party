<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ContactType as Resource;
use DentalSleepSolutions\Contracts\Repositories\ContactTypes as Repository;

class ContactType extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'contacttype', 'description', 'sortby', 'status',
        'adddate', 'ip_address', 'physician', 'corporate'
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
