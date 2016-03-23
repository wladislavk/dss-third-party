<?php

namespace DentalSleepSolutions\Http\Requests;

class TonsilsClinicalExamUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'formid'           => 'integer',
            'patientid'        => 'sometimes|required|integer',
            'mallampati'       => 'string',
            'tonsils'          => 'string',
            'tonsils_grade'    => 'string',
            'userid'           => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'status'           => 'integer',
            'additional_notes' => 'string'
        ];
    }
}
