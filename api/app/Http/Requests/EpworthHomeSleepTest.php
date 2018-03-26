<?php

namespace DentalSleepSolutions\Http\Requests;

class EpworthHomeSleepTest extends Request
{
    protected $rules = [
        'hst_id'     => 'required|integer',
        'epworth_id' => 'required|integer',
        'response'   => 'integer',
    ];
}
