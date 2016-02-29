<?php

namespace DentalSleepSolutions\Http\Requests;

class NoteStore extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'       => 'required|integer',
            'notes'           => 'string',
            'edited'          => 'boolean',
            'editor_initials' => 'string',
            'userid'          => 'required|integer',
            'docid'           => 'required|integer',
            'status'          => 'integer',
            'procedure_date'  => 'date',
            'signed_id'       => 'integer',
            'signed_on'       => 'date',
            'parentid'        => 'integer'
        ];
    }
}
