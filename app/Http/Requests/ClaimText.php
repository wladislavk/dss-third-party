<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimText extends Request
{
    protected $rules = [
        'title'       => 'required|string',
        'description' => 'string',
    ];
}
