<?php

namespace DentalSleepSolutions\Http\Requests;

class SupportAttachment extends Request
{
    protected $rules = [
        'ticket_id'   => 'required|integer',
        'response_id' => 'required|integer',
        'filename'    => ['required', 'regex:/^support_attachment_[0-9]{1,2}_[0-9]_[0-9]{4}\.(gif|jpeg|png|bmp|jpg)$/'],
    ];
}
