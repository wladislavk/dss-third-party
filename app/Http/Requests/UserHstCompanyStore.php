<?php

namespace DentalSleepSolutions\Http\Requests;

class UserHstCompanyStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userid'    => 'required|integer',
            'companyid' => 'required|integer'
        ];
    }
}
