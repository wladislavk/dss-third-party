<?php

namespace DentalSleepSolutions\Http\Requests;

class Medicament extends Request
{
    protected $rules = [
        'medications' => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
