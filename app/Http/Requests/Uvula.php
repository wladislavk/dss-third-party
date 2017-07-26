<?php

namespace DentalSleepSolutions\Http\Requests;

class Uvula extends Request
{
    protected $rules = [
        'uvula'       => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
