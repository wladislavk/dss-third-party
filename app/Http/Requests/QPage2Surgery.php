<?php

namespace DentalSleepSolutions\Http\Requests;

class QPage2Surgery extends Request
{
    protected $rules = [
        'patientid'    => 'required|integer',
        'surgery_date' => 'required|date',
        'surgery'      => 'required|string',
        'surgeon'      => 'required|string',
    ];
}
