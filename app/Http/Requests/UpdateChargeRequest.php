<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateChargeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'                  => 'regex:/[\d]{11},[\d]{2}/',
            'userid'                  => 'integer',
            'adminid'                 => 'integer',
            'charge_date'             => 'date',
            'stripe_customer'         => 'string',
            'stripe_charge'           => 'string',
            'stripe_card_fingerprint' => 'string',
            'invoice_id'              => 'integer',
            'status'                  => 'integer'
        ];
    }
}