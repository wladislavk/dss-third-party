<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerStatement extends Request
{
    protected $rules = [
        'producerid'   => 'required|integer',
        'filename'     => 'regex:/^\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf$/',
        'service_date' => 'date',
        'entry_date'   => 'date',
        'patientid'    => 'required|integer'
    ];
}
