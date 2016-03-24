<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerPaymentUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer'          => 'integer',
            'amount'         => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'payment_type'   => 'integer',
            'payment_date'   => 'date',
            'entry_date'     => 'date',
            'ledgerid'       => 'sometimes|required|integer',
            'allowed'        => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'ins_paid'       => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'deductible'     => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'copay'          => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'coins'          => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'overpaid'       => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'followup'       => 'date',
            'note'           => 'string',
            'amount_allowed' => 'regex:/^[0-9]+\.[0-9]{1,2}$/'
        ];
    }
}
