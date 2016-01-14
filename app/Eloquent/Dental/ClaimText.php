<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ClaimText as Resource;
use DentalSleepSolutions\Contracts\Repositories\ClaimTexts as Repository;

class ClaimText extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'adddate',
        'ip_address', 'default_text', 'companyid'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_claim_text';

    /**
     * Primary key for the table
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
