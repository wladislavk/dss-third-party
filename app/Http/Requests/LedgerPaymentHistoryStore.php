<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerPaymentHistoryStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paymentid'         => 'required|integer',
            'payer'             => 'integer',
            'amount'            => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'payment_type'      => 'integer',
            'payment_date'      => 'date',
            'entry_date'        => 'date',
            'ledgerid'          => 'required|integer',
            'allowed'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'ins_paid'          => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'deductible'        => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'copay'             => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'coins'             => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'overpaid'          => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'followup'          => 'date',
            'note'              => 'string',
            'amount_allowed'    => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'updated_by_user'   => 'integer',
            'updated_by_admin'  => 'integer',
            'updated_at'        => 'date'
        ];
    }
}
