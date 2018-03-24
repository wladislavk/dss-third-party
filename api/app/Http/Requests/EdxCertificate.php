<?php

namespace DentalSleepSolutions\Http\Requests;

class EdxCertificate extends Request
{
    protected $rules = [
        'url'               => 'required|url',
        'edx_id'            => 'required|integer',
        'course_name'       => 'string',
        'course_section'    => 'string',
        'course_subsection' => 'string',
        'number_ce'         => 'integer',
    ];
}
