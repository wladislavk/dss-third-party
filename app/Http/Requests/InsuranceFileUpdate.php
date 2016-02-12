<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceFileUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'     => 'sometimes|required|integer',
            'claimtype'   => ['sometimes', 'required', 'regex:/^(?:primary|secondary)$/'],
            'filename'    => 'sometimes|required|string',
            'description' => 'string',
            'status'      => 'integer'
        ];
    }
}
