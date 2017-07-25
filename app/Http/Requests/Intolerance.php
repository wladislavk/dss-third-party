<?php

namespace DentalSleepSolutions\Http\Requests;

class Intolerance extends Request
{
    protected $rules = [
        'intolerance' => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
