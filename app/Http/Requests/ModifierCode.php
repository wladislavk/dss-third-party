<?php

namespace DentalSleepSolutions\Http\Requests;

class ModifierCode extends Request
{
    protected $rules = [
        'modifier_code' => 'required|string',
        'description'   => 'string',
        'sortby'        => 'integer',
        'status'        => 'integer',
    ];
}
