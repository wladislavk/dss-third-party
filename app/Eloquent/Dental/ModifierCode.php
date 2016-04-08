<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ModifierCode as Resource;
use DentalSleepSolutions\Contracts\Repositories\ModifierCodes as Repository;

class ModifierCode extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['modifier_codeid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_modifier_code';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'modifier_codeid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
