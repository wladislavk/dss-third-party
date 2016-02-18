<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerNoteUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'producerid'       => 'sometimes|required|integer',
            'note'             => 'string',
            'private'          => 'integer',
            'service_date'     => 'date',
            'entry_date'       => 'date',
            'patientid'        => 'sometimes|required|integer',
            'docid'            => 'sometimes|required|integer',
            'admin_producerid' => 'sometimes|required|integer'
        ];
    }
}
