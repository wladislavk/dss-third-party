<?php

namespace DentalSleepSolutions\Http\Requests;

class UserHstCompany extends Request
{
    protected $rules = [
        'userid'    => 'required|integer',
        'companyid' => 'required|integer',
    ];
}
