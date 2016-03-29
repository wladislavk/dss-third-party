<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportResponseUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id'     => 'sometimes|required|integer',
            'responder_id'  => 'sometimes|required|integer',
            'body'          => 'string',
            'response_type' => 'integer',
            'viewed'        => 'boolean',
            'attachment'    => 'string'
        ];
    }
}
