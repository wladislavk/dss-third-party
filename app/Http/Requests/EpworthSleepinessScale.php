<?php

namespace DentalSleepSolutions\Http\Requests;

class EpworthSleepinessScale extends Request
{
    protected $rules = [
        'epworth'     => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
