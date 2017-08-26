<?php

namespace DentalSleepSolutions\Http\Requests;

class MissingTooth extends Request
{
    protected $rules = [
        'formid'    => 'integer',
        'patientid' => 'required|integer',
        'pck'       => 'regex:/^(?:~[0-9]*)+$/',
        'rec'       => 'regex:/^(?:~[0-9]*)+$/',
        'mob'       => 'regex:/^(?:~[0-9]*)+$/',
        'rec1'      => 'regex:/^(?:~[0-9]*)+$/',
        'pck1'      => 'regex:/^(?:~[0-9]*)+$/',
        's1'        => 'integer',
        's2'        => 'integer',
        's3'        => 'integer',
        's4'        => 'integer',
        's5'        => 'integer',
        's6'        => 'integer',
        'userid'    => 'required|integer',
        'docid'     => 'required|integer',
        'status'    => 'integer',
    ];
}
