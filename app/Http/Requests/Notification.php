<?php

namespace DentalSleepSolutions\Http\Requests;

class Notification extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'patientid'         => 'required|integer',
            'docid'             => 'required|integer',
            'notification'      => 'required|string',
            'notification_type' => 'string',
            'status'            => 'integer',
            'notification_date' => 'date'
        ];
    }

    public function updateRules()
    {
        return [
            'patientid'         => 'sometimes|required|integer',
            'docid'             => 'sometimes|required|integer',
            'notification'      => 'sometimes|required|string',
            'notification_type' => 'string',
            'status'            => 'integer',
            'notification_date' => 'date'
        ];
    }
}
