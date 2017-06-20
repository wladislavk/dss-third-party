<?php

namespace DentalSleepSolutions\Http\Requests;

class Notification extends Request
{
    protected $rules = [
        'patientid'         => 'required|integer',
        'docid'             => 'required|integer',
        'notification'      => 'required|string',
        'notification_type' => 'string',
        'status'            => 'integer',
        'notification_date' => 'date'
    ];
}
