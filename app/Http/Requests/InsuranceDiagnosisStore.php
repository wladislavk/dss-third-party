<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDiagnosisStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ins_diagnosis' => 'required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }
}
