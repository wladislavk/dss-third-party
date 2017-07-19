<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\LedgerRecord as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerRecords as Repository;

class LedgerRecord extends AbstractModel implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['ledgerid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_rec';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ledgerid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
