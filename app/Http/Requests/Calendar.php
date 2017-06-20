<?php

namespace DentalSleepSolutions\Http\Requests;

class Calendar extends Request
{
    protected $rules = [
        'start_date'   => 'required|date_format:Y-m-d H:i:s',
        'end_date'     => 'required|date_format:Y-m-d H:i:s|after:start_date',
        'description'  => 'required|string',
        'event_id'     => 'required|regex:/^[0-9]{13}$/',
        'docid'        => 'integer',
        'category'     => 'string',
        'producer_id'  => 'integer',
        'patientid'    => 'integer',
        'rec_type'     => 'string',
        'event_length' => 'integer',
        'event_pid'    => 'integer',
        'res_id'       => 'integer',
        'rec_pattern'  => 'string',
    ];
}
