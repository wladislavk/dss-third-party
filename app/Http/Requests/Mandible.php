<?php

namespace DentalSleepSolutions\Http\Requests;

class Mandible extends Request
{
    protected $rules = [
        'mandible'    => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
