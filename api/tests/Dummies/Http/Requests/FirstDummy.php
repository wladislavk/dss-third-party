<?php

namespace Tests\Dummies\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class FirstDummy extends Request
{
    protected $rules = [
        'first' => 'required|string|max:250|unique:admin',
        'second' => 'required|integer',
        'third' => 'date',
        'fourth' => 'sometimes|required|email',
    ];
}
