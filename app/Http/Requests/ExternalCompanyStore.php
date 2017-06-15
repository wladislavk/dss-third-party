<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalCompanyStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'software' => 'required|string',
            'name' => 'required|string',
            'short_name' => 'required|string',
            'api_key' => 'required|string',
            'valid_from' => 'required|string',
            'valid_to' => 'required|string',
            'url' => 'string',
            'description' => 'string',
            'status' => 'required|integer',
            'reason' => 'string',
        ];
    }
}
