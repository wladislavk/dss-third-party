<?php

namespace DentalSleepSolutions\Http\Requests;

class Login extends Request
{
    protected $rules = [
        'docid'       => 'required|integer',
        'userid'      => 'required|integer',
        'login_date'  => 'date',
        'logout_date' => 'date',
    ];
}
