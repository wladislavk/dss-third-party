<?php

namespace DentalSleepSolutions\Http\Requests;

class DoctorPalpation extends Request
{
    protected $rules = [];
    protected $_rules = [
        'palpationid' => 'required|integer',
        'sortby' => 'integer',
    ];
}
