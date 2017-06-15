<?php

namespace DentalSleepSolutions\Http\Requests;

class InsuranceDiagnosisUpdate extends AbstractUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ins_diagnosis' => 'sometimes|required|string',
            'description'   => 'string',
            'sortby'        => 'integer',
            'status'        => 'integer'
        ];
    }
}
