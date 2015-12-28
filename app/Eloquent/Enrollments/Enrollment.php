<?php

namespace DentalSleepSolutions\Eloquent\Enrollments;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'payer_id', 'payer_name', 'npi', 'reference_id', 'response',
        'tax_id', 'address', 'city', 'state', 'zip', 'first_name', 'last_name',
        'transaction_type_id', 'status', 'facility_name', 'provider_name',
        'contact_number', 'email', 'adddate', 'ip_address',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_eligible_enrollment';

    /**
     * @var bool
     */
    public $timestamps = false;
}
