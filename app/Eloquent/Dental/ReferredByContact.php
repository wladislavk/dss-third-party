<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\ReferredByContact as Resource;
use DentalSleepSolutions\Contracts\Repositories\ReferredByContacts as Repository;

class ReferredByContact extends Model implements Resource, Repository
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_referredby';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'referredbyid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
