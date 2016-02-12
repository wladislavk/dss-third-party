<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceFileStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'claimid'     => 'required|integer',
            'claimtype'   => ['required', 'regex:/^(?:primary|secondary)$/'],
            'filename'    => 'required|string',
            'description' => 'string',
            'status'      => 'integer'
        ];
    }
}
