<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerRecord extends Request
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
            'formid'           => 'integer',
            'patientid'        => 'required|integer',
            'service_date'     => 'string',
            'entry_date'       => 'string',
            'description'      => 'string',
            'producer'         => 'string',
            'amount'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'transaction_type' => 'string',
            'paid_amount'      => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'userid'           => 'required|integer',
            'docid'            => 'required|integer',
            'status'           => 'integer',
            'transaction_code' => 'regex:/^[A-Z][0-9]{4}$/'
        ];
    }

    public function updateRules()
    {
        return [
            'formid'           => 'integer',
            'patientid'        => 'sometimes|required|integer',
            'service_date'     => 'string',
            'entry_date'       => 'string',
            'description'      => 'string',
            'producer'         => 'string',
            'amount'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'transaction_type' => 'string',
            'paid_amount'      => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'userid'           => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'status'           => 'integer',
            'transaction_code' => 'regex:/^[A-Z][0-9]{4}$/'
        ];
    }
}
