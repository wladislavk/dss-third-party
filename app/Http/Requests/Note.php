<?php

namespace DentalSleepSolutions\Http\Requests;

class Note extends Request
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

    public function updateRules()
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
