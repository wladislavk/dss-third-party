<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalUserUpdate extends Request
{
    /**
     * Validate incoming requests to update ExternalUser models
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
