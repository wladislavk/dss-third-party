<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateChargeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'                  => 'sometimes|required|regex:/^\d*(\.\d{2})?$/',
            'userid'                  => 'sometimes|required|integer',
            'adminid'                 => 'sometimes|required|integer',
            'charge_date'             => 'sometimes|required|date',
            'stripe_customer'         => 'string',
            'stripe_charge'           => 'string',
            'stripe_card_fingerprint' => 'string',
            'invoice_id'              => 'integer',
            'status'                  => 'integer'
        ];
    }
}