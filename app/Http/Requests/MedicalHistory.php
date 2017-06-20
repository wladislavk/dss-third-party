<?php

namespace DentalSleepSolutions\Http\Requests;

class MedicalHistory extends Request
{
    protected $rules = [
        'history'     => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
