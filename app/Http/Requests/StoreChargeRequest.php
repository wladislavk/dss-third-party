<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class StoreChargeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'                  => 'required|regex:/^\d*(\.\d{2})?$/',
            'userid'                  => 'required|integer',
            'adminid'                 => 'required|integer',
            'charge_date'             => 'required|date',
            'stripe_customer'         => 'string',
            'stripe_charge'           => 'string',
            'stripe_card_fingerprint' => 'string',
            'invoice_id'              => 'integer',
            'status'                  => 'integer'
        ];
    }
}
