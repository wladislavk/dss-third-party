<?php

namespace DentalSleepSolutions\Http\Requests;

class Form extends Request
{
    protected $rules = [
        'docid'     => 'required|integer',
        'patientid' => 'required|integer',
        'formtype'  => 'integer',
    ];
}
