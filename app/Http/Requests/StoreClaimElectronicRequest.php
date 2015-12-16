<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class StoreClaimElectronicRequest extends Request
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
            'claimid'         => 'integer|required',
            'response'        => 'string',
            'reference_id'    => 'string',
            'percase_date'    => 'date',
            'percase_name'    => 'string',
            'percase_amount'  => 'regex:/^\d*(\.\d{2})?$/',
            'percase_status'  => 'integer',
            'percase_invoice' => 'integer',
            'percase_free'    => 'integer',
        ];
    }
}
