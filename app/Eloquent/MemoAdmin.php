<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MemoAdmin extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'memo_admin';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'memo_id';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['memo', 'last_update', 'off_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
