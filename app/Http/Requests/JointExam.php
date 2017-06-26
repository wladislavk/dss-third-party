<?php

namespace DentalSleepSolutions\Http\Requests;

class JointExam extends Request
{
    protected $rules = [
        'joint_exam'  => 'required|string',
        'description' => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer'
    ];
}
