<?php

namespace DentalSleepSolutions\Eloquent\Enrollments;

use Illuminate\Database\Eloquent\Model;

class PayersList extends Model
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
