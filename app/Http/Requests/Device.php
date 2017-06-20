<?php

namespace DentalSleepSolutions\Http\Requests;

class Device extends Request
{
    protected $rules = [
        'device'      => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
        'image_path'  => 'required|string'
    ];
}
