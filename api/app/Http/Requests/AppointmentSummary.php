<?php

namespace DentalSleepSolutions\Http\Requests;

class AppointmentSummary extends Request
{
    protected $rules = [
        'patientid' => 'integer',
        'stepid' => 'integer',
        'segmentid' => 'integer',
        'date_scheduled' => 'date',
        'date_completed' => 'date',
        'delay_reason' => 'string',
        'study_type' => 'string',
        'letterid' => 'string',
        'description' => 'string',
        'noncomp_reason' => 'string',
        'device_date' => 'date',
        'appointment_type' => 'required|integer',
        'device_id' => 'integer',
    ];
}
