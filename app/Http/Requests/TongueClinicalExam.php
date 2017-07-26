<?php

namespace DentalSleepSolutions\Http\Requests;

class TongueClinicalExam extends Request
{
    protected $rules = [
        'formid'               => 'required|integer',
        'patientid'            => 'required|integer',
        'blood_pressure'       => ['regex:/^[1-2][0-9]{2}\/([5-9][0-9]|1[0-9]{2})$/'],
        'pulse'                => 'string',
        'neck_measurement'     => 'regex:/^([0-9]*[.])?[0-9]+$/',
        'bmi'                  => 'regex:/^[0-9]+\.[0-9]+$/',
        'additional_paragraph' => 'string',
        'tongue'               => 'regex:/^~([0-9]~)+$/',
        'userid'               => 'integer',
        'docid'                => 'integer',
        'status'               => 'integer',
    ];
}
