<?php

namespace DentalSleepSolutions\Http\Requests;

class NotificationStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
}
