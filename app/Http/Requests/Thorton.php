<?php

namespace DentalSleepSolutions\Http\Requests;

class Thorton extends Request
{
    protected $rules = [
        'formid'    => 'integer',
        'patientid' => 'required|integer',
        'snore_1'   => 'integer',
        'snore_2'   => 'integer',
        'snore_3'   => 'integer',
        'snore_4'   => 'integer',
        'snore_5'   => 'integer',
        'tot_score' => 'integer',
        'userid'    => 'required|integer',
        'docid'     => 'required|integer',
        'status'    => 'integer',
    ];
}
