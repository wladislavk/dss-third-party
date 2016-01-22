<?php

namespace DentalSleepSolutions\Http\Requests;

class AdminCompanyUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'adminid'   => 'integer',
            'companyid' => 'integer'
        ];
    }
}