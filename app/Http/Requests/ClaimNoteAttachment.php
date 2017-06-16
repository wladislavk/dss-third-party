<?php

namespace DentalSleepSolutions\Http\Requests;

class ClaimNoteAttachment extends Request
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
            'note_id'  => 'required|integer',
            'filename' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'note_id'  => 'sometimes|required|integer',
            'filename' => 'sometimes|required|string'
        ];
    }
}
