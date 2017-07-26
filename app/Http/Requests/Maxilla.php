<?php

namespace DentalSleepSolutions\Http\Requests;

class Maxilla extends Request
{
    protected $rules = [
        'maxilla'     => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
