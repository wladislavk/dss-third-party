<?php
namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class UpdateClaimElectronicRequest extends Request
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
            'response'        => 'sometimes|required|string',
            'reference_id'    => 'sometimes|required|string',
            'percase_date'    => 'date',
            'percase_name'    => 'sometimes|required|string',
            'percase_amount'  => 'sometimes|required|regex:/^\d*(\.\d{2})?$/',
            'percase_status'  => 'sometimes|required|integer',
            'percase_invoice' => 'integer',
            'percase_free'    => 'integer',
        ];
    }
}