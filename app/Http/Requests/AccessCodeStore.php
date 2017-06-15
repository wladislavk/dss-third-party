<?php

namespace DentalSleepSolutions\Http\Requests;

class AccessCodeStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'access_code' => 'required|string|unique:dental_access_codes',
            'notes'       => 'string',
            'status'      => 'integer',
            'plan_id'     => 'integer'
        ];
    }
}
