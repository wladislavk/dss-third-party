<?php

namespace DentalSleepSolutions\Http\Requests;

class NotificationUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
