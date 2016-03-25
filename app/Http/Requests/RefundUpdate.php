<?php

namespace DentalSleepSolutions\Http\Requests;

class RefundUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'      => 'regex:/^[0-9]+\.[0-9]{1,2}$/',
            'userid'      => 'sometimes|required|integer',
            'adminid'     => 'sometimes|required|integer',
            'refund_date' => 'date',
            'charge_id'   => 'sometimes|required|integer'
        ];
    }
}
