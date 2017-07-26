<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientContact extends Request
{
    protected $rules = [
        'contacttype' => 'required|integer',
        'patientid'   => 'required|integer',
        'firstname'   => 'required|string',
        'lastname'    => 'required|string',
        'address1'    => 'string',
        'address2'    => 'string',
        'city'        => 'string',
        'state'       => 'string',
        'zip'         => 'regex:/^[0-9]{5}$/',
        'phone'       => 'regex:/^[0-9]{10}$/',
    ];
}
