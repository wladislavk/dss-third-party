<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\LedgerPayment as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerPayments as Repository;

class LedgerPayment extends Model implements Resource, Repository
{
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
    protected $table = 'dental_ledger_payment';

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
    protected $dates = [''];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
