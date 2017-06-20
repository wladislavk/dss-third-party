<?php

namespace DentalSleepSolutions\Http\Requests;

class SoftPalate extends Request
{
    protected $rules = [
        'soft_palate' => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
