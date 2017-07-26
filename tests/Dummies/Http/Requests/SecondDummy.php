<?php

namespace Tests\Dummies\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class SecondDummy extends Request
{
    protected $rules = [
        'fifth' => 'boolean',
        'sixth' => 'regex:/foo/',
        'seventh' => ['required', 'regex:/[bar|baz]/'],
    ];
}
