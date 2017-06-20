<?php

namespace DentalSleepSolutions\Http\Requests;

class ProfileImage extends Request
{
    protected $rules = [
        'formid'      => 'integer',
        'patientid'   => 'required|integer',
        'title'       => 'string',
        'image_file'  => 'string',
        'imagetypeid' => 'required|integer',
        'userid'      => 'required|integer',
        'docid'       => 'required|integer',
        'status'      => 'integer',
        'adminid'     => 'integer',
    ];
}
