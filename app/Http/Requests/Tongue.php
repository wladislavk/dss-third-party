<?php

namespace DentalSleepSolutions\Http\Requests;

class Tongue extends Request
{
    protected $rules = [
        'tongue'      => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
