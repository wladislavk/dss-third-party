<?php

namespace DentalSleepSolutions\Http\Requests;

class Diagnostic extends Request
{
    protected $rules = [
        'diagnostic'  => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
