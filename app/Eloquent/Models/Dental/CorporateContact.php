<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\CorporateContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\CorporateContacts as Repository;

class CorporateContact extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['contactid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_fcontact';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'contactid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
