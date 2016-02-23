<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerHistoryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ledgerid'                 => 'sometimes|required|integer',
            'formid'                   => 'integer',
            'patientid'                => 'sometimes|required|integer',
            'service_date'             => 'date',
            'entry_date'               => 'date',
            'description'              => 'string',
            'producer'                 => 'string',
            'amount'                   => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'transaction_type'         => 'string',
            'paid_amount'              => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'userid'                   => 'sometimes|required|integer',
            'docid'                    => 'sometimes|required|integer',
            'status'                   => 'integer',
            'transaction_code'         => 'regex:/^[A-Z][0-9]{4}$/',
            'placeofservice'           => 'string',
            'emg'                      => 'string',
            'diagnosispointer'         => 'string',
            'daysorunits'              => 'string',
            'epsdt'                    => 'string',
            'idqual'                   => 'string',
            'modcode'                  => 'string',
            'producerid'               => 'sometimes|required|integer',
            'primary_claim_id'         => 'integer',
            'primary_paper_claim_id'   => 'string',
            'modcode2'                 => 'string',
            'modcode3'                 => 'string',
            'modcode4'                 => 'string',
            'percase_date'             => 'date',
            'percase_name'             => 'string',
            'percase_amount'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'percase_status'           => 'integer',
            'percase_invoice'          => 'integer',
            'percase_free'             => 'integer',
            'updated_by_user'          => 'integer',
            'updated_by_admin'         => 'integer',
            'primary_claim_history_id' => 'integer',
            'secondary_claim_id'       => 'integer'
        ];
    }
}
