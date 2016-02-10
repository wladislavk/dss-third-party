<?php

namespace DentalSleepSolutions\Http\Requests;

class InsurancePayerStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|string',
            'payer_id' => 'required|string'
        ];
    }
}
