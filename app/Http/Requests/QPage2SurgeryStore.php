<?php

namespace DentalSleepSolutions\Http\Requests;

class QPage2SurgeryStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'    => 'required|integer',
            'surgery_date' => 'required|date',
            'surgery'      => 'required|string',
            'surgeon'      => 'required|string'
        ];
    }
}
