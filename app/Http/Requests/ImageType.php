<?php

namespace DentalSleepSolutions\Http\Requests;

class ImageType extends Request
{
    protected $rules = [
        'imagetype'   => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
