<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;

class Qualifier extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['qualifierid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_qualifier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'qualifierid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getActive()
    {
        return $this->active()
            ->orderBy('sortby')
            ->get();
    }
}
