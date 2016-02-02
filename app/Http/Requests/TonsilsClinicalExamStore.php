<?php

namespace DentalSleepSolutions\Http\Requests;

class TonsilsClinicalExamStore extends Request
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
            'patientid'        => 'required|integer',
            'mallampati'       => 'string',
            'tonsils'          => 'string',
            'tonsils_grade'    => 'string',
            'userid'           => 'required|integer',
            'docid'            => 'required|integer',
            'status'           => 'integer',
            'additional_notes' => 'string'
        ];
    }
}
