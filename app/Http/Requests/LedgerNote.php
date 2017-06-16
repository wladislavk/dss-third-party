<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerNote extends Request
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

    public function updateRules()
    {
        return [
            'producerid'       => 'sometimes|required|integer',
            'note'             => 'string',
            'private'          => 'integer',
            'service_date'     => 'date',
            'entry_date'       => 'date',
            'patientid'        => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'admin_producerid' => 'sometimes|required|integer'
        ];
    }
}
