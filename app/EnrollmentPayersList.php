<?php

namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class EnrollmentPayersList extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['payer_id', 'names', 'supported_endpoints'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enrollment_payers_list';

    /**
     * @var bool
     */
    public $timestamps = false;

}
