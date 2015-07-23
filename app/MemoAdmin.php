<?php

namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class MemoAdmin extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['memo', 'last_update', 'off_date'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'memo_admin';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Primary key for the table
     * @var string
     */
    protected $primaryKey = 'memo_id';

}
