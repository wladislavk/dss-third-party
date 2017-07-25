<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportResponse extends Request
{
    protected $rules = [
        'ticket_id'     => 'required|integer',
        'responder_id'  => 'required|integer',
        'body'          => 'string',
        'response_type' => 'integer',
        'viewed'        => 'boolean',
        'attachment'    => 'string',
    ];
}
