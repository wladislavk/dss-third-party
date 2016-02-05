<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxInvoiceStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id'  => 'required|integer',
            'description' => 'string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
            'amount'      => 'regex:/^\d*(\.\d{2})?$/'
        ];
    }
}
