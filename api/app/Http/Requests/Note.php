<?php

namespace DentalSleepSolutions\Http\Requests;

class Note extends Request
{
    protected $rules = [
        'notes'           => 'string',
        'edited'          => 'boolean',
        'editor_initials' => 'string',
        'status'          => 'integer',
        'procedure_date'  => 'null|date',
        'signed_id'       => 'null|integer',
        'signed_on'       => 'null|date',
        'parentid'        => 'integer',
    ];
}
