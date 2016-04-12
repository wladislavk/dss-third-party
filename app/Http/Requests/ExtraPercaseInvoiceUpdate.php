<?php

namespace DentalSleepSolutions\Http\Requests;

class ExtraPercaseInvoiceUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'percase_date'    => 'sometimes|required|date',
            'percase_name'    => 'sometimes|required|string',
            'percase_amount'  => 'sometimes|required|regex:/^[0-9]+\.[0-9]{1,2}$/',
            'percase_status'  => 'integer',
            'percase_invoice' => 'integer'
        ];
    }
}
