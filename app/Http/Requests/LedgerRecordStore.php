<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerRecordStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'           => 'required|integer',
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
}
