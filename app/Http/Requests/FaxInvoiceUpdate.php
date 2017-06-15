<?php

namespace DentalSleepSolutions\Http\Requests;

class FaxInvoiceUpdate extends AbstractUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id'  => 'sometimes|required|integer',
            'description' => 'string',
            'start_date'  => 'sometimes|required|date',
            'end_date'    => 'sometimes|required|date',
            'amount'      => 'regex:/^\d*(\.\d{2})?$/'
        ];
    }
}
