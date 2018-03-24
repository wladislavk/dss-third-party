<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDocument extends Request
{
    protected $rules = [
        'title'       => 'required|string',
        'description' => 'required|string',
        'video_file'  => 'string',
        'doc_file'    => 'string',
        'sortby'      => 'integer',
        'status'      => 'integer',
        'docid'       => 'string',
    ];
}
