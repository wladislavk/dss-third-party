<?php

namespace DentalSleepSolutions\Http\Requests;

class PaymentReportUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'      => 'sometimes|required|integer',
            'reference_id' => 'sometimes|required|string',
            'response'     => 'json',
            'viewed'       => 'boolean'
        ];
    }
}
