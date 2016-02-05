<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\FaxErrorCode as Resource;
use DentalSleepSolutions\Contracts\Repositories\FaxErrorCodes as Repository;

class FaxErrorCode extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['error_code', 'description', 'resolution'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_fax_error_codes';

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
