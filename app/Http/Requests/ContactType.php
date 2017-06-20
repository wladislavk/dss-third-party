<?php

namespace DentalSleepSolutions\Http\Requests;

class ContactType extends Request
{
    protected $rules = [
        'contacttype' => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
        'physician'   => 'integer',
        'corporate'   => 'integer',
    ];
}
