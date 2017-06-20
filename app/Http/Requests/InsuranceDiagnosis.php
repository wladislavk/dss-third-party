<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDiagnosis extends Request
{
    protected $rules = [
        'ins_diagnosis' => 'required|string',
        'description'   => 'string',
        'sortby'        => 'integer',
        'status'        => 'integer',
    ];
}
