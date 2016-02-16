<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceStatusHistoryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'insuranceid' => 'sometimes|required|integer',
            'status'      => 'integer',
            'userid'      => 'sometimes|required|integer',
            'adminid'     => 'sometimes|required|integer'
        ];
    }
}
