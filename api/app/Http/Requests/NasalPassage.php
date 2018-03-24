<?php

namespace DentalSleepSolutions\Http\Requests;

class NasalPassage extends Request
{
    protected $rules = [
        'nasal_passages' => 'required|string',
        'description'    => 'string',
        'sortby'         => 'integer',
        'status'         => 'integer',
    ];
}
