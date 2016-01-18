<?php

namespace DentalSleepSolutions\Http\Requests;

class CalendarUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date'   => 'sometimes|required|date_format:Y-m-d H:i:s',
            'end_date'     => 'sometimes|required|date_format:Y-m-d H:i:s|after:start_date',
            'description'  => 'sometimes|required|string',
            'event_id'     => 'sometimes|required|regex:/^[0-9]{13}$/',
            'docid'        => 'integer',
            'category'     => 'string',
            'producer_id'  => 'integer',
            'patientid'    => 'integer',
            'rec_type'     => 'string',
            'event_length' => 'integer',
            'event_pid'    => 'integer',
            'res_id'       => 'integer',
            'rec_pattern'  => 'string'
        ];
    }
}
