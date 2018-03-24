<?php

namespace DentalSleepSolutions\Http\Requests;

class AppointmentType extends Request
{
    protected $rules = [
        'name'      => 'string',
        'color'     => 'required|string',
        'classname' => 'required|string',
        'docid'     => 'required|integer',
    ];
}
