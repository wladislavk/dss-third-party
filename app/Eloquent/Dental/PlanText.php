<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PlanText as Resource;
use DentalSleepSolutions\Contracts\Repositories\PlanTexts as Repository;

class PlanText extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['plan_textid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_plan_text';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'plan_textid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
