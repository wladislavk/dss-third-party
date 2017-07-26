<?php

namespace DentalSleepSolutions\Http\Requests;

class PatientInsurance extends Request
{
    protected $rules = [
        'patientid'     => 'required|integer',
        'insurancetype' => 'integer',
        'company'       => 'required|string',
        'address1'      => 'string',
        'address2'      => 'string',
        'city'          => 'string',
        'state'         => 'string',
        'zip'           => 'regex:/[0-9]{5}/',
        'phone'         => 'regex:/[0-9]{10}/',
        'fax'           => 'string',
        'email'         => 'email',
    ];
}
