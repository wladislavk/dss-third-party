<?php

namespace DentalSleepSolutions\Http\Requests;

class Qualifier extends Request
{
    protected $rules = [
        'qualifier'   => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
