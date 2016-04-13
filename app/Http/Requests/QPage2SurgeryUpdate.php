<?php

namespace DentalSleepSolutions\Http\Requests;

class QPage2SurgeryUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'    => 'sometimes|required|integer',
            'surgery_date' => 'sometimes|required|date',
            'surgery'      => 'sometimes|required|string',
            'surgeon'      => 'sometimes|required|string'
        ];
    }
}
