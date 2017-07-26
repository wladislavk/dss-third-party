<?php

namespace DentalSleepSolutions\Http\Requests;

class Task extends Request
{
    protected $rules = [
        'task'           => 'required|string',
        'description'    => 'string',
        'userid'         => 'required|integer',
        'responsibleid'  => 'required|integer',
        'status'         => 'integer',
        'due_date'       => 'date',
        'recurring'      => 'integer',
        'recurring_unit' => 'integer',
        'patientid'      => 'required|integer',
    ];
}
