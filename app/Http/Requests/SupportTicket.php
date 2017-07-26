<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportTicket extends Request
{
    protected $rules = [
        'title'       => 'string',
        'userid'      => 'required|integer',
        'docid'       => 'required|integer',
        'body'        => 'string',
        'category_id' => 'required|integer',
        'status'      => 'integer',
        'attachment'  => 'string',
        'viewed'      => 'boolean',
        'creator_id'  => 'integer',
        'create_type' => 'integer',
        'company_id'  => 'integer',
    ];
}
