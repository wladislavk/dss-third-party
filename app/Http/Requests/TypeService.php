<?php

namespace DentalSleepSolutions\Http\Requests;

class TypeService extends Request
{
    protected $rules = [
        'type_service' => 'required|string',
        'description'  => 'string',
        'sortby'       => 'integer',
        'status'       => 'required|integer',
    ];
}
