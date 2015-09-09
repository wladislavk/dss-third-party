<?php

namespace DentalSleepSolutions;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable =
        ['user_id',
            'payer_id',
            'payer_name',
            'npi',
            'reference_id',
            'response',
            'transaction_type_id',
            'status',
            'facility_name',
            'provider_name',
            'tax_id',
            'address',
            'city',
            'state',
            'zip',
            'first_name',
            'last_name',
            'contact_number',
            'email',
            'adddate',
            'ip_address',];


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
