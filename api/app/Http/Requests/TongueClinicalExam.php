<?php

namespace DentalSleepSolutions\Http\Requests;

class TongueClinicalExam extends Request
{
    protected $rules = [
        'formid'               => 'required|integer',
        'blood_pressure'       => ['regex:/^\d+(\/\d+)?$/'],
        'pulse'                => 'string',
        'neck_measurement'     => 'regex:/^([0-9]*[.])?[0-9]+$/',
        'bmi'                  => 'regex:/^[0-9]+\.[0-9]+$/',
        'additional_paragraph' => 'string',
        'tongue'               => 'regex:/^~([0-9]~)+$/',
        'status'               => 'integer',
    ];
}
