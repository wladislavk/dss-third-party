<?php

namespace DentalSleepSolutions\Http\Requests;

class UserHstCompanyUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userid'    => 'sometimes|required|integer',
            'companyid' => 'sometimes|required|integer'
        ];
    }
}
