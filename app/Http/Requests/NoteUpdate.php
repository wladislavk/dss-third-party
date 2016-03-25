<?php

namespace DentalSleepSolutions\Http\Requests;

class NoteUpdate extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patientid'       => 'sometimes|required|integer',
            'notes'           => 'string',
            'edited'          => 'boolean',
            'editor_initials' => 'string',
            'userid'          => 'sometimes|required|integer',
            'docid'           => 'sometimes|required|integer',
            'status'          => 'integer',
            'procedure_date'  => 'date',
            'signed_id'       => 'integer',
            'signed_on'       => 'date',
            'parentid'        => 'integer'
        ];
    }
}
