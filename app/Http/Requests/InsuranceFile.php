<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceFile extends Request
{
    protected $rules = [
        'claimid'     => 'required|integer',
        'claimtype'   => ['required', 'regex:/^(?:primary|secondary)$/'],
        'filename'    => 'required|string',
        'description' => 'string',
        'status'      => 'integer'
    ];
}
