<?php

namespace DentalSleepSolutions\Http\Requests;

class Note extends Request
{
    protected $rules = [
        'patientid'       => 'required|integer',
        'notes'           => 'string',
        'edited'          => 'boolean',
        'editor_initials' => 'string',
        'userid'          => 'required|integer',
        'docid'           => 'required|integer',
        'status'          => 'integer',
        'procedure_date'  => 'date',
        'signed_id'       => 'integer',
        'signed_on'       => 'date',
        'parentid'        => 'integer',
    ];
}
