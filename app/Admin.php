<?php
namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'adminid';
}
