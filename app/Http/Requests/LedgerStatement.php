<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerStatement extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'producerid'   => 'required|integer',
            'filename'     => 'regex:/^\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf$/',
            'service_date' => 'date',
            'entry_date'   => 'date',
            'patientid'    => 'required|integer'
        ];
    }

    public function updateRules()
    {
        return [
            'producerid'   => 'sometimes|required|integer',
            'filename'     => 'regex:/^\/manage\/letterpdfs\/statement_[0-9]+_[0-9]+\.pdf$/',
            'service_date' => 'date',
            'entry_date'   => 'date',
            'patientid'    => 'sometimes|required|integer'
        ];
    }
}
