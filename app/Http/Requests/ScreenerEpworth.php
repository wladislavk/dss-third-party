<?php

namespace DentalSleepSolutions\Http\Requests;

class ScreenerEpworth extends Request
{
    protected $rules = [
        'screener_id' => 'required|integer',
        'epworth_id'  => 'required|integer',
        'response'    => 'required|integer',
    ];
}
