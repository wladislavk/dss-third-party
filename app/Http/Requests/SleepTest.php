<?php

namespace DentalSleepSolutions\Http\Requests;

class SleepTest extends Request
{
    protected $rules = [
        'formid'           => 'integer',
        'patientid'        => 'required|integer',
        'epworthid'        => ['regex:/^([0-9]{1,2}\|[0-9]{1,2}~)+$/'],
        'analysis'         => 'string',
        'userid'           => 'required|integer',
        'docid'            => 'required|integer',
        'status'           => 'integer',
        'parent_patientid' => 'integer'
    ];
}
