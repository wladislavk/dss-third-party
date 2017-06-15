<?php

namespace DentalSleepSolutions\Http\Requests;

class ExternalUserStore extends Request
{
    /**
     * Validate incoming requests to store ExternalUser models
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
