<?php

namespace DentalSleepSolutions\Http\Requests;

class AccessCode extends Request
{
    protected $rules = [
        'access_code' => 'required|string|unique:dental_access_codes',
        'notes'       => 'string',
        'status'      => 'integer',
        'plan_id'     => 'integer',
    ];
}
