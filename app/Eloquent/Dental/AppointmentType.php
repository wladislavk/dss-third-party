<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\AppointmentType as Resource;
use DentalSleepSolutions\Contracts\Repositories\AppointmentTypes as Repository;

class AppointmentType extends Model implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'color', 'classname', 'docid'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_appt_types';

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
    protected $primaryKey = 'id';
}
