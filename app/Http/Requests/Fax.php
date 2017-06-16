<?php

namespace DentalSleepSolutions\Http\Requests;

class Fax extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'invoice_id'  => 'required|integer',
            'description' => 'string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
            'amount'      => 'regex:/^\d*(\.\d{2})?$/'
        ];
    }

    public function updateRules()
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
