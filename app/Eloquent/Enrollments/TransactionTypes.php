<?php

namespace DentalSleepSolutions\Eloquent\Enrollments;

use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'transaction_type', 'description', 'addddate',
        'ip_address', 'status', 'endpoint',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_enrollment_transaction_type';

    /**
     * @var bool
     */
    public $timestamps = false;
}
