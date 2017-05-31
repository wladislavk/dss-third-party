<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerStatementUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
