<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceType extends Request
{
    protected $rules = [
        'ins_type'    => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
