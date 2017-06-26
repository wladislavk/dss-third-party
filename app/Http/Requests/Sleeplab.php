<?php

namespace DentalSleepSolutions\Http\Requests;

class Sleeplab extends Request
{
    protected $rules = [
        'docid'      => 'integer',
        'salutation' => 'string',
        'lastname'   => 'required|string',
        'firstname'  => 'required|string',
        'middlename' => 'string',
        'company'    => 'required|string',
        'add1'       => 'required|string',
        'add2'       => 'string',
        'city'       => 'required|string',
        'state'      => 'required|string',
        'zip'        => 'required|regex:/^[0-9]{5}$/',
        'phone1'     => 'regex:/^[0-9]{10}$/',
        'phone2'     => 'regex:/^[0-9]{10}$/',
        'fax'        => 'regex:/^[0-9]{10}$/',
        'email'      => 'email',
        'greeting'   => 'string',
        'sincerely'  => 'string',
        'notes'      => 'string',
        'status'     => 'integer',
    ];
}
