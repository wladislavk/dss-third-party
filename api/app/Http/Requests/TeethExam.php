<?php

namespace DentalSleepSolutions\Http\Requests;

class TeethExam extends Request
{
    protected $rules = [
        'exam_teeth'  => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
    ];
}
