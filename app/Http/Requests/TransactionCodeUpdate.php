<?php

namespace DentalSleepSolutions\Http\Requests;

class TransactionCodeUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_code' => 'sometimes|required|string',
            'description'      => 'sometimes|required|string',
            'type'             => 'sometimes|required|regex:/^[0-9]$/',
            'sortby'           => 'integer',
            'status'           => 'integer',
            'default_code'     => 'integer',
            'docid'            => 'sometimes|required|integer',
            'amount'           => 'regex:/^[0-9]+\.[0-9]{2}$/',
            'place'            => 'integer',
            'modifier_code_1'  => 'string',
            'modifier_code_2'  => 'string',
            'days_units'       => 'regex:/^[0-9]$/',
            'amount_adjust'    => 'integer'
        ];
    }
}
