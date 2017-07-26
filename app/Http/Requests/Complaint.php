<?php

namespace DentalSleepSolutions\Http\Requests;

class Complaint extends Request
{
    protected $rules = [
        'complaint'   => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
