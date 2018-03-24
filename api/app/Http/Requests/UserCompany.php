<?php

namespace DentalSleepSolutions\Http\Requests;

class UserCompany extends Request
{
    protected $rules = [
        'userid'    => 'required|integer',
        'companyid' => 'required|integer',
    ];
}
