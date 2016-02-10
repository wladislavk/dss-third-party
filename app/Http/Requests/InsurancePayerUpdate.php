<?php

namespace DentalSleepSolutions\Http\Requests;

class InsurancePayerUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'sometimes|required|string',
            'payer_id' => 'sometimes|required|string'
        ];
    }
}
