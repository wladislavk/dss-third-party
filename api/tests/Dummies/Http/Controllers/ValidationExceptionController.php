<?php

namespace Tests\Dummies\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ValidationExceptionController extends Controller
{
    private $rules = [
        'amount' => 'required|numeric',
    ];

    public function main()
    {
        $this->validate($this->request, $this->rules);
        return new Response();
    }
}
