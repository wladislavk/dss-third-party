<?php

namespace DentalSleepSolutions\Http\Requests;

class TonsilsClinicalExam extends Request
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

    public function updateRules()
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
