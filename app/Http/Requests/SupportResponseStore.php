<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportResponseStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id'     => 'required|integer',
            'responder_id'  => 'required|integer',
            'body'          => 'string',
            'response_type' => 'integer',
            'viewed'        => 'boolean',
            'attachment'    => 'string'
        ];
    }
}
