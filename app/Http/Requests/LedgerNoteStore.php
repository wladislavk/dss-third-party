<?php

namespace DentalSleepSolutions\Http\Requests;

class LedgerNoteStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'producerid'       => 'required|integer',
            'note'             => 'string',
            'private'          => 'integer',
            'service_date'     => 'date',
            'entry_date'       => 'date',
            'patientid'        => 'required|integer',
            'docid'            => 'required|integer',
            'admin_producerid' => 'required|integer'
        ];
    }
}
