<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutCreatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\LedgerHistory as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerHistories as Repository;

class LedgerHistory extends Model implements Resource, Repository
{
    use WithoutCreatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_history';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['percase_date'];
}
