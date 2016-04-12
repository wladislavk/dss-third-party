<?php

namespace DentalSleepSolutions\Http\Requests;

class ExtraPercaseInvoiceStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'percase_date'    => 'required|date',
            'percase_name'    => 'required|string',
            'percase_amount'  => 'required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'percase_status'  => 'integer',
            'percase_invoice' => 'integer'
        ];
    }
}
