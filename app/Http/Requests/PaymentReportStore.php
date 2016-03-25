<?php

namespace DentalSleepSolutions\Http\Requests;

class PaymentReportStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'      => 'required|integer',
            'reference_id' => 'required|string',
            'response'     => 'json',
            'viewed'       => 'boolean'
        ];
    }
}
