<?php

namespace DentalSleepSolutions\Http\Requests;

class PercaseInvoiceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'adminid'             => 'sometimes|required|integer',
            'docid'               => 'sometimes|required|integer',
            'monthly_fee_date'    => 'date',
            'monthly_fee_amount'  => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'status'              => 'integer',
            'due_date'            => 'date',
            'companyid'           => 'integer',
            'user_fee_date'       => 'date',
            'user_fee_amount'     => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'producer_fee_date'   => 'date',
            'producer_fee_amount' => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'user_fee_desc'       => 'string',
            'producer_fee_desc'   => 'string',
            'invoice_type'        => 'integer'
        ];
    }
}
