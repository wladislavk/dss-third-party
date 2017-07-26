<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerNote extends Request
{
    protected $rules = [
        'producerid'       => 'required|integer',
        'note'             => 'string',
        'private'          => 'integer',
        'service_date'     => 'date',
        'entry_date'       => 'date',
        'patientid'        => 'required|integer',
        'docid'            => 'required|integer',
        'admin_producerid' => 'required|integer'
    ];
}
