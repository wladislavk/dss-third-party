<?php

namespace DentalSleepSolutions\Http\Requests;

class ChangeList extends Request
{
    protected $rules = [
        'content' => 'required|string',
    ];
}
