<?php

namespace DentalSleepSolutions\Http\Requests;

class TonsilsClinicalExam extends Request
{
    protected $rules = [
        'formid'           => 'integer',
        'patientid'        => 'required|integer',
        'mallampati'       => 'string',
        'tonsils'          => 'string',
        'tonsils_grade'    => 'string',
        'userid'           => 'required|integer',
        'docid'            => 'required|integer',
        'status'           => 'integer',
        'additional_notes' => 'string',
    ];
}
