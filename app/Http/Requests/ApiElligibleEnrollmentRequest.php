<?php

namespace DentalSleepSolutions\Http\Requests;

use DentalSleepSolutions\Http\Requests\Request;

class ApiElligibleEnrollmentRequest extends Request
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
            'payer_id'          => 'required',
            'facility_name'     => 'required',
            'provider_name'     => 'required',
            'npi'               => 'required',
        ];
    }
}
