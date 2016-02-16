<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceStatusHistoryStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'insuranceid' => 'required|integer',
            'status'      => 'integer',
            'userid'      => 'required|integer',
            'adminid'     => 'required|integer'
        ];
    }
}
