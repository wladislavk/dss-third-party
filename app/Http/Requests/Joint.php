<?php

namespace DentalSleepSolutions\Http\Requests;

class Joint extends Request
{
    protected $rules = [
        'joint'       => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
