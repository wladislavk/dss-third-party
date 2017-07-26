<?php

namespace DentalSleepSolutions\Http\Requests;

class Palpation extends Request
{
    protected $rules = [
        'palpation'   => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
