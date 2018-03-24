<?php

namespace DentalSleepSolutions\Http\Requests;

class GagReflex extends Request
{
    protected $rules = [
        'gag_reflex'  => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
