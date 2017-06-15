<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalUserStore extends AbstractStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'api_key' => 'required|string',
            'valid_from' => 'required|string',
            'valid_to' => 'required|string',
            'enabled' => 'required|boolean',
        ];
    }
}
