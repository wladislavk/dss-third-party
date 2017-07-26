<?php

namespace DentalSleepSolutions\Http\Requests;

class DocumentCategory extends Request
{
    protected $rules = [
        'name'   => 'required|string',
        'status' => 'integer'
    ];
}
